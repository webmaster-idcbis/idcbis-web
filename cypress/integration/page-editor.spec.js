/// <reference types="cypress" />

describe('Admin - Page Editor', () => {
  beforeEach(() => {
    cy.visit('/login')
    cy.get('[data-cy=email]').type('admin@test.com')
    cy.get('[data-cy=password]').type('password')
    cy.get('[data-cy=submit]').click()
    cy.url().should('include', '/admin/dashboard')
  })

  it('muestra el editor con paleta y plantillas base', () => {
    cy.visit('/admin/pages/create')
    cy.contains('Nueva página').should('be.visible')
    cy.get('[data-cy=palette-search]').should('be.visible')
    cy.get('[data-cy=btn-template-servicios]').should('be.visible')
    cy.get('[data-cy=btn-template-propuesta-azul]').should('be.visible')
    cy.get('[data-cy=btn-save-template]').should('be.visible')
  })

  it('carga la plantilla Servicios', () => {
    cy.visit('/admin/pages/create')
    cy.on('window:confirm', () => true)
    cy.get('[data-cy=btn-template-servicios]').click()
    cy.contains('Arrastra elementos aquí').should('not.exist')
  })

  it('permite buscar elementos en la paleta', () => {
    cy.visit('/admin/pages/create')
    cy.get('[data-cy=palette-search]').type('acordeón')
    cy.get('[data-cy=palette-item-accordion]').should('be.visible')
  })

  it('muestra campos SEO al expandir', () => {
    cy.visit('/admin/pages/create')
    cy.contains('Datos de página').click()
    cy.contains('SEO (opcional)').click()
    cy.get('[data-cy=input-meta-title]').should('be.visible')
    cy.get('[data-cy=input-meta-description]').should('be.visible')
    cy.get('[data-cy=input-meta-keywords]').should('be.visible')
  })

  it('valida título obligatorio al guardar', () => {
    cy.visit('/admin/pages/create')
    cy.get('[data-cy=btn-save]').click()
    cy.on('window:alert', (text) => {
      expect(text).to.contain('título')
    })
  })
})
