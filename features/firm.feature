Feature: Manage Firm
  Scenario: It should be render firm's list
    Given I am on "/firms"
    Then the response status code should be 200
    And I should see "Liste des sociétés"
    And I should see "Créer"
    And I should see "Nom"
    And I should see "Status Juridique"
    And I should see "SIREN"
    And I should see "Ville d'inscription"
    And I should see "Date d'inscription"
    And I should see "Capital"
    And I should see "Date de création"
    And I should see "Date de modification"
    And I should see "Actions"
    And I should see a pagination

  Scenario: It should add firm
    Given I am on "/firms/new"
    Then the response status code should be 200
    And I should see "Créer une société"
    When I POST a valid request to "/firms/new" the following data:
    """
    {
      "firm": {
        "legalForm": 2,
        "name": "Test firm",
        "siren": "459 673 107",
        "registerCity": "Paris",
        "dateRegister": "03-12-1990",
        "capital": "45000",
        "address": [
          {
            "number": 2,
            "type": "Boulevard",
            "name": "Hausseman",
            "city": "Paris",
            "zipCode": "75009"
          }
        ]
      }
    }
    """
    And the response status code should be 200
    And I should be on "/firms/"

  Scenario: It should render firm's page
    Given I am on "/firms/test-firm"
    Then the response status code should be 200

  Scenario: It should render firm's page
    Given I am on "/firms/benard"
    Then the response status code should be 200
    And I should see "Afficher la société \"Benard\""
    And I should see "Version"
    And I should see "Status Juridique"
    And I should see "Groupement de droit privé non doté de la personnalité morale"
    And I should see "Nom"
    And I should see "Benard"
    And I should see "SIREN"
    And I should see "144 692 347"
    And I should see "Ville d'inscription"
    And I should see "Pineau"
    And I should see "Date d'inscription"
    And I should see "12 mars 1991"
    And I should see "Capital"
    And I should see "44268"
    And I should see "Date de création"
    And I should see "Date de modification"
    And I should see "Adresses"
    And I should see "Numéro"
    And I should see "Type de voie"
    And I should see "Nom de l'adresse"
    And I should see "Ville"
    And I should see "Code Postal"
    And I should see "489"
    And I should see "place"
    And I should see "Noël Gerard"
    And I should see "Dufour"
    And I should see "78 575"
    And I should see "8"
    And I should see "impasse"
    And I should see "Josette Blin"
    And I should see "Langlois"
    And I should see "92088"
    And I should see "Retour à la liste"
    And I should see "Editer"

  Scenario: It should edit firm
    Given I am on "/firms/benard"
    Then the response status code should be 200
    And I follow "Editer"
    And I should be on "/firms/benard/edit"
    Then the response status code should be 200
    And I should see "Editer la société \"Benard\""
    And I select "2" from "firm_legalForm"
    And I fill in "firm_capital" with "45000"
    And I press "Enregistrer"
    Then the response status code should be 200
    And I should be on "/firms/"
    Given I am on "/firms/benard"
    And I should not see "44268"
    But I should see "45000"
    And I should not see "Groupement de droit privé non doté de la personnalité morale"
    But I should see "Indivision"

  Scenario: It should render version of firm
    Given I am on "/firms/benard?version=1"
    Then the response status code should be 200
    And I should see "Groupement de droit privé non doté de la personnalité morale"
    But I should not see "Indivision"
