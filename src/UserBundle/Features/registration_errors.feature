Feature: Handle registration errors
  We should check the username and email are unique and all fields are correctly set

  Scenario: Register with missing last name should show an error
    When I am on "/register/coordinator"
    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "user.last_name.error.missing"
    Then I should see "user.first_name.error.missing"
    Then I should see "user.username.error.missing"
    Then I should see "user.email.error.missing"


  Scenario: Register with an already existing email should show an duplicated email message
    Given there is users with the following details:
      | last_name | first_name | username | email              | phone      | plainPassword |
      | Michaux   | Cédric     | he8us    | cedric@example.com | 0412345678 | 12345         |


    When I am on "/register/coordinator"

    Then I fill in the following:
      | user_register_lastName             | Michaux            |
      | user_register_firstName            | Cédric             |
      | user_register_username             | he8us_second       |
      | user_register_email_first          | cedric@example.com |
      | user_register_email_second         | cedric@example.com |
      | user_register_phone                | 0412345678         |
      | user_register_plainPassword_first  | 12345              |
      | user_register_plainPassword_second | 12345              |

    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "user.email.error.duplicate"


  Scenario: Register with an already existing username should show an duplicated username message
    Given there is users with the following details:
      | uid | last_name | first_name | username | email              | phone      | plainPassword |
      | 1   | Michaux   | Cédric     | he8us    | cedric@example.com | 0412345678 | 12345         |


    When I am on "/register/coordinator"

    Then I fill in the following:
      | user_register_lastName             | Michaux                |
      | user_register_firstName            | Cédric                 |
      | user_register_username             | he8us                  |
      | user_register_email_first          | cedric_second@he8us.be |
      | user_register_email_second         | cedric_second@he8us.be |
      | user_register_phone                | 0412345678             |
      | user_register_plainPassword_first  | 12345                  |
      | user_register_plainPassword_second | 12345                  |

    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "user.username.error.duplicate"

