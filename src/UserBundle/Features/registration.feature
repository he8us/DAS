Feature: Registration for user types

  Scenario: The register page is accessible from the homepage
    Given I am on the homepage
    Then I follow the Register link
    Then I should be on the Register page

  Scenario: Create an account for Coordinator
    Given I am on the Register page

    Then I follow the Coordinator link

    Then I should be on the "Coordinator" registration page

    When I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form
    Then I should be on the homepage
    Then I should be welcomed


  Scenario: Create an account for Teacher
    Given I am on the Register page

    Then I follow the Teacher link

    Then I should be on the "Teacher" registration page

    When I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form
    Then I should be on the homepage
    And I should be welcomed


  Scenario: Create an account for Titular
    Given I am on the Register page

    Then I follow the Titular link

    Then I should be on the Titular registration page

    When I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form
    Then I should be on the homepage
    And I should be welcomed


  Scenario: Create an account for Course Titular
    Given I am on the Register page

    Then I follow the "Course Titular" link

    Then I should be on the "Course Titular" registration page

    When I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form

    Then I should be on the homepage
    And I should be welcomed


  Scenario: Create an account for Parent
    Given I am on the Register page

    Then I follow the Parent link

    Then I should be on the Parent registration page

    When I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form
    Then I should be on the homepage
    And I should be welcomed


  Scenario: The password should be encoded in the database
    Given I am on the Coordinator registration page
    Then I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us           |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    And I submit the form

    Then the user "he8us" should not have "password" equal to "12345"

