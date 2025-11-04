                                                                        GreenLife Wellness Center - Admin Dashboard

 NOTE : WE CAN ALSO CREATE AN ACCOUNT FOR CLIENT AND HERAPIST BY REGISTERING AS THEIR SPECIFIC ROLE AND THEN LOGIN. 
FOR ADMIN LOGIN SEPERATELY, CLICK ON LOGIN AND TYPE BELOW GIVEN CREDENTIALS 

1. Admin Login Credentials: 
   - Email: admin@greenlife.com
   - Password: admin123
   - Password is hashed in the database using bcrypt:
   - Hash.php 
     $2y$10$B9di8Y.KYat5JxF3.nNreuhC0FRVFRkePfgvMwVN/RbgAbFpTM4oi

client login credentials
 -Email: client@greenlife.com
 -password: 123


Therapist login Credentials:
 - Email: therapist@greenlife.com
 - password: 123

2. Admin Dashboard Features:
   - View all registered users with options to delete users.
   - View all appointments with options to cancel appointments.
   - View all client messages with options to delete messages.
   - New Search Appointments feature:
     * Search by client name or email.
     * Filter appointments by service.
     * Filter appointments by appointment date.
     * Filtered results appear in a table below the search form.
     * You can cancel appointments directly from the filtered results.

3. Usage Instructions:
   - Login as admin using the credentials above.
   - Navigate to the Admin Dashboard.
   - Use the "Search Appointments" section to find specific appointments quickly.
   - Use the "All Appointments" section to see the complete list without filters.
   - Manage users, appointments, and messages as needed.

4. Technical Notes:
   - Passwords are securely hashed using PHP's password_hash function (bcrypt).
   - The search and filter form uses GET parameters to filter appointments.
   - Database connection settings are in `../backend/db.php`.
   - Make sure your PHP environment supports MySQLi prepared statements.


Thank you for using GreenLife Wellness Center Admin Dashboard!

