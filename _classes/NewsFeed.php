<?php

$myNews = new NewsFeed();

echo '<pre>';
echo var_dump($myNews);
echo '</pre>';

class NewsFeed
{
    public $NewsID = 0;
    public $Title = "";
    public $Description = "";
    public $DateAdded = "";
    public $LastUpdated = "";
    public $isValid = FALSE;
	
	/**
	 * Constructor for NewsFeed class. 
	 *
	 * @param integer $id The unique ID number of the Survey
	 * @return void 
	 * @todo none
	 */ 
    function __construct($id)
    {#constructor sets stage by adding data to an instance of the object
        $this->NewsID = (int)$id;
        if($this->NewsID == 0){return FALSE;}
		
        #get Survey data from DB
        $sql = sprintf("select Title, Description, DateAdded, LastUpdated from " . PREFIX . "News Where NewsID =%d",$this->NewsID);
		
        #in mysqli, connection and query are reversed!  connection comes first
        $result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
        if (mysqli_num_rows($result) > 0)
        {
            $this->isValid = TRUE;
            while ($row = mysqli_fetch_assoc($result))
            {#dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
                $this->Title = dbOut($row['Title']);
                $this->Description = dbOut($row['Description']);
                $this->DateAdded = dbOut($row['DateAdded']);
                $this->LastUpdated = dbOut($row['LastUpdated']);
            }
        }
        @mysqli_free_result($result); #free resources
		
        if(!$this->isValid){return;}  #exit, as News Article is not valid
        
    }#end of News Constructor
}
		
		/* attempt to create question objects
		$sql = sprintf("select QuestionID, Question, Description from " . PREFIX . "questions where SurveyID =%d",$this->SurveyID);
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0)
		{#show results
		   while ($row = mysqli_fetch_assoc($result))
		   {
				#create question, and push onto stack!
				$this->aQuestion[] = new Question(dbOut($row['QuestionID']),dbOut($row['Question']),dbOut($row['Description'])); 
		   }
		}
		$this->TotalQuestions = count($this->aQuestion); //the count of the aQuestion array is the total number of questions
		@mysqli_free_result($result); #free resources
		
		#attempt to load all Answer objects into cooresponding Question objects 
	    $sql = "select a.AnswerID, a.Answer, a.Description, a.QuestionID from  
		" . PREFIX . "surveys s inner join " . PREFIX . "questions q on q.SurveyID=s.SurveyID 
		inner join " . PREFIX . "answers a on a.QuestionID=q.QuestionID   
		where s.SurveyID = %d   
		order by a.AnswerID asc";
		$sql = sprintf($sql,$this->SurveyID); #process SQL
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0)
		{#at least one answer!
		   while ($row = mysqli_fetch_assoc($result))
		   {#match answers to questions
			    $QuestionID = (int)$row['QuestionID']; #process db var
				foreach($this->aQuestion as $question)
				{#Check db questionID against Question Object ID
					if($question->QuestionID == $QuestionID)
					{
						$question->TotalAnswers += 1;  #increment total number of answers
						#create answer, and push onto stack!
						$question->aAnswer[] = new Answer((int)$row['AnswerID'],dbOut($row['Answer']),dbOut($row['Description']));
						break; 
					}
				}	
		   }
		}
	} 
    
*/ 