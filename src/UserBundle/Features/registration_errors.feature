Feature: Handle registration errors
  We should check the username and email are unique and all fields are correctly set

  Scenario: Register with missing last name should show an error
    When I am on "/register/coordinator"
    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "form.security.last_name.error.missing"
    Then I should see "form.security.first_name.error.missing"
    Then I should see "form.security.username.error.missing"
    Then I should see "form.security.email.error.missing"
    Then I should see "form.security.password.error.missing"


  Scenario: Register with an already existing email should show an duplicated email message
    Given there is users with the following details:
      | last_name | first_name | username | email           | phone      | plainPassword |
      | Michaux   | Cédric     | he8us    | cedric@he8us.be | 0471711666 | 12345         |


    When I am on "/register/coordinator"

    Then I fill in the following:
      | user_lastName             | Michaux         |
      | user_firstName            | Cédric          |
      | user_username             | he8us_second    |
      | user_email_first          | cedric@he8us.be |
      | user_email_second         | cedric@he8us.be |
      | user_phone                | 0471711666      |
      | user_plainPassword_first  | 12345           |
      | user_plainPassword_second | 12345           |

    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "form.security.email.error.duplicate"


  Scenario: Register with an already existing username should show an duplicated username message
    Given there is users with the following details:
      | uid | last_name | first_name | username | email           | phone      | plainPassword |
      | 1   | Michaux   | Cédric     | he8us    | cedric@he8us.be | 0471711666 | 12345         |


    When I am on "/register/coordinator"

    Then I fill in the following:
      | user_lastName             | Michaux                |
      | user_firstName            | Cédric                 |
      | user_username             | he8us                  |
      | user_email_first          | cedric_second@he8us.be |
      | user_email_second         | cedric_second@he8us.be |
      | user_phone                | 0471711666             |
      | user_plainPassword_first  | 12345                  |
      | user_plainPassword_second | 12345                  |

    When I press "_submit"
    Then I should be on "/register/coordinator"
    Then I should see "form.security.username.error.duplicate"

