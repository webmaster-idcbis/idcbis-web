/// <reference types="cypress" />

describe('Admin - Menús', () => {
  beforeEach(() => {
    // Login antes de cada test
    cy.visit('/login');
    cy.get('[data-cy=email]').type('admin@test.com');
    cy.get('[data-cy=password]').type('password');
    cy.get('[data-cy=submit]').click();
    
    // Esperar redirección al dashboard
    cy.url().should('include', '/admin/dashboard');
  });

  it('debe mostrar la lista de menús', () => {
    cy.visit('/admin/menus');
    
    // Verificar elementos principales
    cy.contains('h1', 'Gestión de Menús').should('be.visible');
    cy.get('[data-cy=btn-new-menu]').should('be.visible');
    cy.get('table').should('exist');
  });

  it('debe crear un menú header', () => {
    cy.visit('/admin/menus');
    
    // Abrir modal
    cy.get('[data-cy=btn-new-menu]').click();
    cy.get('[data-cy=modal-menu]').should('be.visible');
    
    // Completar formulario
    cy.get('[data-cy=input-name]').type('Menú Test Cypress');
    cy.get('[data-cy=select-location]').select('header');
    cy.get('[data-cy=input-order]').clear().type('1');
    
    // Agregar item
    cy.get('[data-cy=btn-add-item]').click();
    cy.get('[data-cy=item-title-0]').type('Inicio');
    cy.get('[data-cy=item-type-0]').select('url');
    cy.get('[data-cy=item-url-0]').type('/inicio');
    cy.get('[data-cy=item-target-0]').select('_self');
    
    // Guardar
    cy.get('[data-cy=btn-save]').click();
    
    // Verificar éxito
    cy.contains('Menú creado exitosamente').should('be.visible');
    cy.get('table').contains('Menú Test Cypress');
  });

  it('debe crear un menú footer', () => {
    cy.visit('/admin/menus');
    
    cy.get('[data-cy=btn-new-menu]').click();
    cy.get('[data-cy=input-name]').type('Footer Test');
    cy.get('[data-cy=select-location]').select('footer');
    
    // Agregar item de página
    cy.get('[data-cy=btn-add-item]').click();
    cy.get('[data-cy=item-title-0]').type('Contacto');
    cy.get('[data-cy=item-type-0]').select('page');
    // Seleccionar primera página disponible
    cy.get('[data-cy=item-page-0]').select(0);
    
    cy.get('[data-cy=btn-save]').click();
    cy.contains('Menú creado exitosamente').should('be.visible');
  });

  it('debe validar campos requeridos', () => {
    cy.visit('/admin/menus');
    
    cy.get('[data-cy=btn-new-menu]').click();
    cy.get('[data-cy=btn-save]').click();
    
    // Verificar errores de validación
    cy.contains('El nombre es requerido').should('be.visible');
  });

  it('debe editar un menú existente', () => {
    // Crear menú primero
    cy.request({
      method: 'POST',
      url: '/api/menus',
      headers: { Authorization: `Bearer ${window.localStorage.getItem('token')}` },
      body: {
        name: 'Menú Editar Test',
        location: 'header',
        items: [],
        is_active: true,
        order: 1
      }
    });
    
    cy.visit('/admin/menus');
    cy.contains('Menú Editar Test').parent().find('[data-cy=btn-edit]').click();
    
    // Modificar
    cy.get('[data-cy=input-name]').clear().type('Menú Actualizado');
    cy.get('[data-cy=btn-save]').click();
    
    cy.contains('Menú actualizado exitosamente').should('be.visible');
    cy.contains('Menú Actualizado').should('be.visible');
  });

  it('debe eliminar un menú', () => {
    cy.visit('/admin/menus');
    
    // Buscar menú de test y eliminar
    cy.contains('Menú Test Cypress').parent().find('[data-cy=btn-delete]').click();
    cy.get('[data-cy=modal-confirm]').should('be.visible');
    cy.get('[data-cy=btn-confirm-delete]').click();
    
    cy.contains('Menú eliminado exitosamente').should('be.visible');
  });

  it('debe alternar entre modo claro y oscuro', () => {
    cy.visit('/admin/menus');
    
    // Verificar modo oscuro
    cy.get('html').then(($html) => {
      if ($html.hasClass('dark')) {
        cy.get('body').should('have.class', 'dark');
        cy.get('[data-cy=main-content]').should('have.css', 'background-color', 'rgb(15, 20, 25)');
      }
    });
    
    // Toggle modo oscuro
    cy.get('[data-cy=toggle-dark-mode]').click();
    cy.get('html').should('have.class', 'dark');
  });

  it('debe mostrar menús con el location correcto', () => {
    cy.visit('/admin/menus');
    
    // Verificar badge de location
    cy.get('table tbody tr').each(($row) => {
      cy.wrap($row).within(() => {
        cy.get('[data-cy=badge-location]').should('exist');
      });
    });
  });
});
