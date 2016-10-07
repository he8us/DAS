Feature: A user is able to log in the application

  Scenario: The login page is accessible from the homepage
    Given I am on the homepage
    Then I follow the Login link
    Then I should be on the Student login page
    Then I follow the "I am not a student" link
    Then I should be on the User login page

  Scenario: I should be able to login as Student
    Given there is a Student with credentials "he8us" and "12345" in the database
    And I am on the Student login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed


  Scenario: I should be able to login as Coordinator
    Given there is a Coordinator with credentials "he8us" and "12345" in the database
    And I am on the User login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed

  Scenario: I should be able to login as Teacher
    Given there is a Teacher with credentials "he8us" and "12345" in the database
    And I am on the User login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed

  Scenario: I should be able to login as Titular
    Given there is a Titular with credentials "he8us" and "12345" in the database
    And I am on the User login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed

  Scenario: I should be able to login as Course_Titular
    Given there is a "Course Titular" with credentials "he8us" and "12345" in the database
    And I am on the User login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed

  Scenario: I should be able to login as Parent
    Given there is a Parent with credentials "he8us" and "12345" in the database
    And I am on the User login page

    Then I fill the login form with "he8us" and "12345"
    And I submit the form

    Then I should be welcomed
