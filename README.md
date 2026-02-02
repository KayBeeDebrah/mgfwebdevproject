# mgfwebdevproject

Skill Test Assessment

# MGF Web Developer Exercise

This project illustrates a contacts web application built with Laravel 12 and SQLite.

Before the JSON data is seeded, it demonstrates how database tables and relationships are created. It further implements the daisyUI Tailwind CSS plugin for styling forms and pages.

## Features

The application makes use of 2 models, controllers, and has 5 main views/pages described below.

1. **Layout Page**  
   A template used to display all child pages.

2. **Index Page – `/contacts/`**  
   The initial child page implements a soft delete feature and also displays a list of contacts with pagination, filtering, and sorting capabilities.

3. **Create Page – `/contacts/create`**  
   Displays a validated form that accepts user input to create a new contact.

4. **Edit Page – `/contacts/{id}/edit`**  
   Displays a validated form preloaded with the selected contact’s details and accepts new user input to update a contact.

5. **Report Page – `/contacts/report`**  
   Displays a summary of contacts based on post code.

6. **Unit Test – **  
   A unit test is then conducted to assess the validation of contacts creation and updates.
