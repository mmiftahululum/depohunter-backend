Task: Create an Interactive Deposit Interest Rate Matrix
1. Objective

Create an interactive deposit interest rate matrix that displays the minimum deposit amount in Indonesian Rupiah (IDR) on the left side and deposit tenors in months as column headers.

Each cell in the matrix represents the interest rate for a specific combination of minimum deposit amount and deposit tenor.

2. Data Source

Use the existing database containing the following entities:

Products
Deposit tenors
Interest rates
Minimum deposit amounts

Analyze the existing database schema and relationships before making any changes. Reuse the existing tables and data wherever possible.

3. Table Layout

Create a matrix with the following structure:

Minimum Deposit (IDR)	1 Month	3 Months	6 Months	12 Months
Rp1,000,000	3.00%	3.25%	3.50%	3.75%
Rp10,000,000	3.25%	3.50%	3.75%	4.00%
Rp50,000,000	3.50%	3.75%	4.00%	4.25%
Rp100,000,000	3.75%	4.00%	4.25%	4.50%

The values above are illustrative examples only. Load the actual values from the existing database.

4. Inline Editing

Users must be able to edit interest rates directly within the matrix without opening a separate edit form.

Requirements:

Clicking an interest rate cell should allow the user to edit its value.
The interest rate should be editable as a percentage.
Users should be able to save changes directly from the cell.
Support keyboard navigation between cells where practical.
Display a loading indicator while saving.
Show a success message when the update succeeds.
Display an error message if the update fails.
Preserve the original value if the update fails.
Validate that the interest rate is a valid numeric value.
Prevent invalid values from being saved.
Avoid requiring a full-page reload after an update.
5. Backend Requirements

Implement the necessary Laravel backend functionality to:

Retrieve deposit products, minimum deposit amounts, tenors, and interest rates.
Provide API endpoints for retrieving the matrix data.
Provide an endpoint for updating an individual interest rate.
Validate incoming data on the server.
Update only the selected interest rate record.
Return a clear success or error response.
Use database transactions when necessary to maintain data integrity.
6. Frontend Requirements

Use Vue.js to implement the interactive matrix.

The interface must:

Display minimum deposit amounts as rows.
Display deposit tenors in months as columns.
Display the corresponding interest rates in each cell.
Support inline editing.
Update individual cells without refreshing the entire page.
Provide clear visual feedback for editable, saving, successful, and failed states.
Use a responsive layout suitable for desktop and mobile devices.
Support horizontal scrolling on mobile devices when the matrix contains many tenor columns.
7. Product Filtering

If the database contains multiple deposit products, provide a product selector above the matrix.

When a product is selected, load the corresponding minimum deposit amounts, tenors, and interest rates for that product.

8. Data Integrity
Each interest rate must correspond to the correct product, minimum deposit amount, and tenor.
Do not create duplicate interest rate records.
Do not overwrite unrelated interest rates when updating a cell.
Follow the existing database schema and business rules.
Ensure that changes are persisted in the database and remain available after the page is refreshed.
9. Implementation Instructions

Before implementation:

Inspect the existing Laravel application structure.
Inspect the existing MySQL database schema and identify the product, tenor, minimum deposit, and interest rate tables.
Determine the relationships between the relevant tables.
Identify the existing Vue.js components and API conventions.
Propose an implementation plan based on the existing architecture.

Then implement the feature incrementally:

Create or update the backend query and API endpoints.
Implement the matrix data transformation.
Build the Vue.js matrix component.
Implement inline editing and saving.
Add validation and error handling.
Test data retrieval, updates, and persistence.
Verify responsive behavior.

Do not redesign or replace the existing database schema unless necessary. Explain any required schema changes before applying them.

Expected Result

An interactive deposit interest rate matrix where users can select a deposit product, view minimum deposit amounts and tenors, and modify interest rates directly in the corresponding cells. Changes must be saved to the existing MySQL database through the Laravel backend without reloading the entire page.