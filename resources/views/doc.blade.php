<!DOCTYPE html>
<html>
<head>
    <title>API Documentation</title>
</head>
<body>

<h1>API Documentation</h1>

<h2>POST - /v1/token/refresh</h2>
<p><strong>Purpose:</strong> To get a new access token</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>None</li>
</ul>

<h2>POST - /v1/register</h2>
<p><strong>Purpose:</strong> To sign up a user</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>email (string, required) - User's email address</li>
    <li>password (string, required) - User's password</li>
    <li>first_name (string, required) - User's first name</li>
    <li>last_name (string, required) - User's last name</li>
</ul>

<h2>POST - /v1/logout</h2>
<p><strong>Purpose:</strong> To invalidate the refresh token</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>None</li>
</ul>

<h2>POST - /v1/login</h2>
<p><strong>Purpose:</strong> To get an access token and refresh token</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>email (string, required) - User's email address</li>
    <li>password (string, required) - User's password</li>
</ul>

<h2>POST - /v1/candidates</h2>
<p><strong>Purpose:</strong> To save a candidate</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>first_name (string, required) - Candidate's first name</li>
    <li>last_name (string, required) - Candidate's last name</li>
    <!-- Add more candidate parameters as needed -->
</ul>

<h2>GET - /v1/candidates/{id}</h2>
<p><strong>Purpose:</strong> To retrieve a specific candidate</p>
<p><strong>HTTP Method:</strong> GET</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>None</li>
</ul>

<h2>GET - /v1/candidates</h2>
<p><strong>Purpose:</strong> To get all candidates with pagination</p>
<p><strong>HTTP Method:</strong> GET</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>page (integer, optional) - Page number for pagination</li>
    <li>per_page (integer, optional) - Number of items per page</li>
</ul>

<h2>POST - /v1/candidates/search</h2>
<p><strong>Purpose:</strong> To search for candidates with pagination</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>keyword (string, optional) - Search keyword</li>
    <li>department (string, optional) - Candidate's department</li>
    <li>min_salary (float, optional) - Minimum salary expectation</li>
    <li>max_salary (float, optional) - Maximum salary expectation</li>
    <li>page (integer, optional) - Page number for pagination</li>
    <li>per_page (integer, optional) - Number of items per page</li>
</ul>

<h2>DELETE - /v1/candidates/{id}</h2>
<p><strong>Purpose:</strong> To delete a specific candidate</p>
<p><strong>HTTP Method:</strong> DELETE</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>None</li>
</ul>

<h2>POST - /v1/candidates/{id}</h2>
<p><strong>Purpose:</strong> To update a candidate</p>
<p><strong>HTTP Method:</strong> POST</p>
<p><strong>Parameters:</strong></p>
<ul>
    <li>first_name (string, optional) - Candidate's first name</li>
    <li>last_name (string, optional) - Candidate's last name</li>
    <!-- Add more candidate parameters as needed -->
</ul>

<hr>
<p>For more detailed information and request/response examples, please refer to the API documentation available at http://localhost:8080/docs.</p>

</body>
</html>