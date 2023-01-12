**About This Module**

**Product's Question and Answer Module**
	- On the product detail page, create tab Question/Answer tab.
	- Create a product attribute -> Enable Question/Answer Tab.
	- If admin enable this value than and only than Question/Answer tab should visible.
	- Under it show the recently Q/A asked by the user/admin.
	- User can ask the Question for the product such as Is it avaiable in color Red?
	
  Form should contains -> 
		1. Name -> text -> If customer is loggedIn this field should be auto fill. 
		2. Email -> text -> If customer is loggedIn this field should be auto fill.
		3. Question -> textarea

**Client side validation and server side validation must be there.**
	- User posted Question visible on the admin area and admin will decide weather this question should be visible on the tab of the frontend or not. Admin can provide the answer of the asked question.
	- Question status are -> Pending, Rejected, Approved.
	- Default asked question status must be pending. 
	- Create grid at admin will show the all questions asked by the user.


**Enhancement:**
	-> When user submits the questions -> send the email to the user that his/her question is posted successfully.
	-> when admin approves with answer than user should receive an email that admin has provied the answer {answer_of_admin} for this question {question_asked_user}.
	-> If admin rejects the question -> send email to the user, We are sorry your question is matching our privacy policy.  
