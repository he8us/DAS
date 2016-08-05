Feature: A user is able to log in the application

  Scenario: The login page is accessible from the homepage
    Given I am on the homepage
    Then I follow the Login link
    Then I should be on the Student login page
    Then I follow the "I am not a student" link
    Then I should be on the User login page

  Scenario: I should be able to login as Coordinator
    Given there is a Student with credentials "he8us" and "12345" in the database
    And I am on the Student login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed

