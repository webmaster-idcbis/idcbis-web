<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApiAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function editor_cannot_manage_users_or_roles_but_can_update_own_profile(): void
    {
        $this->seedRoles();

        $editor = User::factory()->create([
            'email' => 'editor@idcbis.org.co',
            'password' => 'Secret123!',
        ]);
        $editor->assignRole('editor');
        Sanctum::actingAs($editor);

        $adminRole = Role::where('name', 'admin')->first();
        $this->putJson("/api/roles/{$adminRole->id}", [
            'name' => 'admin',
            'permissions' => ['pages.view'],
        ])->assertForbidden();

        $admin = User::role('admin')->first();
        $this->putJson("/api/users/{$admin->id}", [
            'name' => 'Tomado',
            'roles' => ['admin'],
        ])->assertForbidden();

        $this->deleteJson("/api/users/{$admin->id}")->assertForbidden();

        $this->putJson('/api/user/profile', [
            'name' => 'Editor IDCBIS',
            'email' => 'editor@idcbis.org.co',
        ])->assertOk()
            ->assertJsonPath('data.name', 'Editor IDCBIS');
    }

    /** @test */
    public function viewer_cannot_publish_pages(): void
    {
        $this->seedRoles();

        $viewer = User::factory()->create();
        $viewer->assignRole('viewer');
        Sanctum::actingAs($viewer);

        $page = Page::factory()->draft()->create();

        $this->getJson('/api/pages')->assertOk();
        $this->patchJson("/api/pages/{$page->id}/publish")->assertForbidden();
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inactivo@idcbis.org.co',
            'password' => 'Secret123!',
            'is_active' => false,
        ]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Secret123!',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    /** @test */
    public function active_user_can_login_and_receives_role_permissions(): void
    {
        $this->seedRoles();

        $editor = User::factory()->create([
            'email' => 'activo@idcbis.org.co',
            'password' => 'Secret123!',
            'is_active' => true,
        ]);
        $editor->assignRole('editor');

        $response = $this->postJson('/api/login', [
            'email' => 'activo@idcbis.org.co',
            'password' => 'Secret123!',
        ]);

        $response->assertOk()
            ->assertJsonPath('user.email', 'activo@idcbis.org.co');

        $permissions = $response->json('user.permissions');
        $this->assertContains('pages.edit', $permissions);
        $this->assertNotContains('users.edit', $permissions);
        $this->assertNotContains('menus.edit', $permissions);
    }

    /** @test */
    public function login_is_throttled_after_five_attempts(): void
    {
        $payload = [
            'email' => 'nadie@idcbis.org.co',
            'password' => 'incorrecta',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/login', $payload)->assertStatus(422);
        }

        $this->postJson('/api/login', $payload)->assertStatus(429);
    }

    /** @test */
    public function public_menu_is_available_without_a_token(): void
    {
        Menu::factory()->header()->create([
            'name' => 'Principal',
            'items' => [
                [
                    'type' => 'url',
                    'title' => 'Inicio',
                    'url' => '/',
                    'target' => '_self',
                    'order' => 0,
                ],
            ],
        ]);

        $this->getJson('/api/menus/public')
            ->assertOk()
            ->assertJsonPath('data.name', 'Principal')
            ->assertJsonPath('data.items.0.title', 'Inicio');
    }

    /** @test */
    public function saving_a_page_menu_item_keeps_page_id_and_children(): void
    {
        $admin = User::factory()->create();
        $this->grantAdmin($admin);
        Sanctum::actingAs($admin);

        $page = Page::factory()->published()->create(['slug' => 'quienes-somos']);

        $response = $this->postJson('/api/menus', [
            'name' => 'Cabecera',
            'location' => 'header',
            'is_active' => true,
            'order' => 1,
            'items' => [
                [
                    'type' => 'page',
                    'title' => 'Quiénes somos',
                    'page_id' => $page->id,
                    'url' => '/quienes-somos',
                    'target' => '_self',
                    'order' => 0,
                    'children' => [
                        [
                            'type' => 'url',
                            'title' => 'Contacto',
                            'url' => '/contacto',
                            'target' => '_self',
                            'order' => 0,
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.items.0.page_id', $page->id)
            ->assertJsonPath('data.items.0.children.0.title', 'Contacto');

        $menu = Menu::where('name', 'Cabecera')->first();
        $this->assertSame($page->id, $menu->items[0]['page_id']);
        $this->assertSame('Contacto', $menu->items[0]['children'][0]['title']);
    }
}
