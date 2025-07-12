Feature: Baselinker Integration

    Scenario: Test if user can initialize getOrders method - allegro
        When I visit the Baselinker marketplace getOrder initialization page for "allegro"
        Then I should see a success message for "allegro"
        And The logs should contain the order list

    Scenario: Test if user can initialize getOrders method - amazon
        When I visit the Baselinker marketplace getOrder initialization page for "amazon"
        Then I should see a success message for "amazon"
        And The logs should contain the order list
