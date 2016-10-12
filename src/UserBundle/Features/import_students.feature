Feature: Import students via the administration panel

  Background:
    Given the database is empty
    And the fixtures "@UserBundle/DataFixtures/ORM/Coordinator.yml" are loaded
    And I am authenticated as "Coordinator"

  Scenario: Import students via excel file
    Given I am on the Student list page
    Then I follow the Import link

    Then I should be on the Student Import page

