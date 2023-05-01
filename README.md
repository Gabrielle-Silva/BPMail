# BPMail
**Aplication to send emails and verify files according to employees names**

##
<h3>🔹 What it does:</h3>

This application was developed to select employees for specific tasks and build/send customized emails to each of them. Its distinctive feature is that when all employee files are dropped into a specific folder, the application automatically attaches the file that contains the employee's name and last name in the path to their respective email. It also has the option to validate whether each page of each file contains the name and last name inside the PDF, and the user can preview the file as well.
##
<h3>🔹 What I used:</h3>

PHP
JavaScript
CSS
HTML
APIs used: PDFJS and PHPMailer.

All the front-end was produced by me, and the only library used for styling was Font Awesome to obtain icons.
##
<h3>🔹 Why I developed it:</h3>

This application was built for my personal use to facilitate my work routine, where I sometimes have to manually send dozens of emails for each employee and verify that the files are correct for that person. Using my knowledge, I was able to make this process less prone to error and reduce the time it takes to complete the task from hours to less than 5 minutes.
##
<h3>🔹 Is it finished:</h3>

There are more improvements to make in the future. For professional use, I plan to add a configuration page where the user can change information about the sender and make other small adjustments to the code. However, it works fine for my current needs, and I intend to focus on other projects for now.
##
<h3>🔹How it works: </h3>

First, select the employees who wish to send an email. There is a filter for the "contrato" field and an option to select all.

![image](https://user-images.githubusercontent.com/95390786/235407209-7c256669-7c2a-4d08-9787-c2b419cec119.png)

You can also add, delete, or update data on the list of employees.

![image](https://user-images.githubusercontent.com/95390786/235408444-7b95d4d6-7a59-4901-ba6a-77cd25b6ec0b.png)

The next page has an option to add a message and subject for all the emails. You can also customize an introduction, where Nome will be substituted for the name of each recipient. There is a button to clear all the inputs, reload the page, add Cc, and attach files that go to everyone.

![image](https://user-images.githubusercontent.com/95390786/235407974-0c37169f-3791-47d8-ac7f-feb8c61e9cd7.png)

Besides to the general configuration, you can change individual information.

![image](https://user-images.githubusercontent.com/95390786/235409385-32573e3a-1754-4b18-86da-c4a90edf628b.png)

The next page is the preview, where you can see the final email before sending.

![image](https://user-images.githubusercontent.com/95390786/235409506-62e28da4-cae5-4290-aa1d-11032fe33635.png)
