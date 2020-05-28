Feature: Redirection to firms
  Scenario: it should redirection to list of firms
    Given I am on "/"
    Then the response status code should be 200
    And I should be on "/firms/"
