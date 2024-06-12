describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('maxime@gmail.com');
        cy.get('#password').type('123456');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('You are logged in as maxime@gmail.com').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#username').type('maxime@gmail.com');
        cy.get('#password').type('hgfghjkl');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});