Feature: Login as student and see if we can logout

  Background:
    Given there are Students with the following details:
      | uid | username   | barcode | first_name | last_name |
      | 1   | john_smith | 12345   | John       | Smith     |


  Scenario: login and logout with user john_smith
    Given I am on "/student/login"
    When I fill in "_username" with "john_smith"
    When I fill in "_barcode" with "12345"
    When I press "_submit"
    Then I should be on "/student/dashboard"
    Then I should see "user.hello"
    When I follow "_logout"
    Then I should be on "/"
