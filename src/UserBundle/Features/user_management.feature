Feature: List the users in the application

  Background:
    Given the database is empty
    And the fixtures "@UserBundle" are loaded
    And I am authenticated as "Coordinator"

  Scenario: List Users
    Given I am on the user listing page
    Then I should see "layout.user.list"
