Feature: A user is able to log in the application

  Scenario: The login page is accessible from the homepage
    Given I am on the homepage
    Then I follow the Login link
    Then I should be on the Student login page
    Then I follow the "I am not a student" link
    Then I should be on the User login page


  Scenario Outline: I should be able to login as any type of Users
    Given there is a "<userType>" with credentials <username> and <password> in the database
    And I am on the <loginPage> login page

    Then I fill the login form with <username> and <password>

    And I submit the form
    Then I should be welcomed

    Examples:
      | userType       | loginPage | username | password |
      | Student        | Student   | he8us    | 12345    |
      | Coordinator    | User      | he8us    | 12345    |
      | Teacher        | User      | he8us    | 12345    |
      | Titular        | User      | he8us    | 12345    |
      | Course Titular | User      | he8us    | 12345    |
      | Parent         | User      | he8us    | 12345    |
      | Super Admin    | User      | he8us    | 12345    |
