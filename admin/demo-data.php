<?php
/**
 * Demo Data for BoldMCQs Theme
 * 
 * This file contains sample MCQs, categories, and tags for testing the theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get demo categories
 */
function boldmcqs_get_demo_categories() {
    return array(
        array(
            'name' => 'General Knowledge',
            'slug' => 'general-knowledge',
            'description' => 'Test your general knowledge with these questions'
        ),
        array(
            'name' => 'Science & Technology',
            'slug' => 'science-technology',
            'description' => 'Questions about science, technology, and innovation'
        ),
        array(
            'name' => 'History & Geography',
            'slug' => 'history-geography',
            'description' => 'Explore historical events and geographical facts'
        ),
        array(
            'name' => 'Mathematics',
            'slug' => 'mathematics',
            'description' => 'Mathematical problems and concepts'
        ),
        array(
            'name' => 'English & Literature',
            'slug' => 'english-literature',
            'description' => 'Grammar, vocabulary, and literary knowledge'
        ),
        array(
            'name' => 'Current Affairs',
            'slug' => 'current-affairs',
            'description' => 'Stay updated with current events and news'
        ),
        array(
            'name' => 'Computer Science',
            'slug' => 'computer-science',
            'description' => 'Programming, algorithms, and computer fundamentals'
        ),
        array(
            'name' => 'Sports & Entertainment',
            'slug' => 'sports-entertainment',
            'description' => 'Sports, movies, music, and entertainment trivia'
        )
    );
}

/**
 * Get demo tags
 */
function boldmcqs_get_demo_tags() {
    return array(
        'beginner', 'intermediate', 'advanced', 'quick-test', 
        'challenging', 'fun-facts', 'competitive-exam', 'brain-teaser',
        'logical-reasoning', 'trivia', 'educational', 'professional'
    );
}

/**
 * Get demo MCQs
 */
function boldmcqs_get_demo_mcqs() {
    return array(
        // General Knowledge
        array(
            'title' => 'What is the capital of France?',
            'category' => 'general-knowledge',
            'tags' => array('beginner', 'quick-test'),
            'difficulty' => 'easy',
            'option_a' => 'London',
            'option_b' => 'Berlin',
            'option_c' => 'Paris',
            'option_d' => 'Madrid',
            'correct_option' => 'C',
            'explanation' => 'Paris is the capital and most populous city of France. It is located in the north-central part of the country.'
        ),
        array(
            'title' => 'Which planet is known as the Red Planet?',
            'category' => 'general-knowledge',
            'tags' => array('beginner', 'trivia'),
            'difficulty' => 'easy',
            'option_a' => 'Venus',
            'option_b' => 'Mars',
            'option_c' => 'Jupiter',
            'option_d' => 'Saturn',
            'correct_option' => 'B',
            'explanation' => 'Mars is called the Red Planet because of its reddish appearance, caused by iron oxide (rust) on its surface.'
        ),
        array(
            'title' => 'Who painted the Mona Lisa?',
            'category' => 'general-knowledge',
            'tags' => array('intermediate', 'educational'),
            'difficulty' => 'medium',
            'option_a' => 'Vincent van Gogh',
            'option_b' => 'Pablo Picasso',
            'option_c' => 'Leonardo da Vinci',
            'option_d' => 'Michelangelo',
            'correct_option' => 'C',
            'explanation' => 'Leonardo da Vinci painted the Mona Lisa in the early 16th century. It is one of the most famous paintings in the world.'
        ),
        
        // Science & Technology
        array(
            'title' => 'What is the chemical symbol for Gold?',
            'category' => 'science-technology',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => 'Go',
            'option_b' => 'Gd',
            'option_c' => 'Au',
            'option_d' => 'Ag',
            'correct_option' => 'C',
            'explanation' => 'The chemical symbol for gold is Au, derived from the Latin word "aurum" meaning gold.'
        ),
        array(
            'title' => 'Who is known as the father of computers?',
            'category' => 'science-technology',
            'tags' => array('intermediate', 'computer-basics'),
            'difficulty' => 'medium',
            'option_a' => 'Steve Jobs',
            'option_b' => 'Bill Gates',
            'option_c' => 'Charles Babbage',
            'option_d' => 'Alan Turing',
            'correct_option' => 'C',
            'explanation' => 'Charles Babbage is considered the "father of the computer" for his invention of the Analytical Engine in the 1830s.'
        ),
        array(
            'title' => 'What does DNA stand for?',
            'category' => 'science-technology',
            'tags' => array('intermediate', 'educational'),
            'difficulty' => 'medium',
            'option_a' => 'Deoxyribonucleic Acid',
            'option_b' => 'Dynamic Nuclear Analysis',
            'option_c' => 'Digital Network Access',
            'option_d' => 'Dual Nitrogen Atom',
            'correct_option' => 'A',
            'explanation' => 'DNA stands for Deoxyribonucleic Acid, which carries genetic information in living organisms.'
        ),
        
        // History & Geography
        array(
            'title' => 'In which year did World War II end?',
            'category' => 'history-geography',
            'tags' => array('intermediate', 'educational'),
            'difficulty' => 'medium',
            'option_a' => '1943',
            'option_b' => '1944',
            'option_c' => '1945',
            'option_d' => '1946',
            'correct_option' => 'C',
            'explanation' => 'World War II ended in 1945 with the surrender of Germany in May and Japan in September.'
        ),
        array(
            'title' => 'What is the longest river in the world?',
            'category' => 'history-geography',
            'tags' => array('intermediate', 'trivia'),
            'difficulty' => 'medium',
            'option_a' => 'Amazon River',
            'option_b' => 'Nile River',
            'option_c' => 'Yangtze River',
            'option_d' => 'Mississippi River',
            'correct_option' => 'B',
            'explanation' => 'The Nile River in Africa is generally considered the longest river in the world at approximately 6,650 km.'
        ),
        array(
            'title' => 'Which ancient wonder of the world still exists today?',
            'category' => 'history-geography',
            'tags' => array('advanced', 'challenging'),
            'difficulty' => 'hard',
            'option_a' => 'Hanging Gardens of Babylon',
            'option_b' => 'Colossus of Rhodes',
            'option_c' => 'Great Pyramid of Giza',
            'option_d' => 'Lighthouse of Alexandria',
            'correct_option' => 'C',
            'explanation' => 'The Great Pyramid of Giza is the only one of the Seven Ancient Wonders of the World that still exists today.'
        ),
        
        // Mathematics
        array(
            'title' => 'What is the value of Pi (π) approximately?',
            'category' => 'mathematics',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => '3.14',
            'option_b' => '3.41',
            'option_c' => '2.14',
            'option_d' => '4.13',
            'correct_option' => 'A',
            'explanation' => 'Pi (π) is approximately 3.14159. It represents the ratio of a circle\'s circumference to its diameter.'
        ),
        array(
            'title' => 'What is 15% of 200?',
            'category' => 'mathematics',
            'tags' => array('intermediate', 'quick-test'),
            'difficulty' => 'medium',
            'option_a' => '25',
            'option_b' => '30',
            'option_c' => '35',
            'option_d' => '40',
            'correct_option' => 'B',
            'explanation' => '15% of 200 = (15/100) × 200 = 30'
        ),
        array(
            'title' => 'What is the square root of 144?',
            'category' => 'mathematics',
            'tags' => array('beginner', 'quick-test'),
            'difficulty' => 'easy',
            'option_a' => '10',
            'option_b' => '11',
            'option_c' => '12',
            'option_d' => '13',
            'correct_option' => 'C',
            'explanation' => 'The square root of 144 is 12, because 12 × 12 = 144.'
        ),
        
        // English & Literature
        array(
            'title' => 'Who wrote "Romeo and Juliet"?',
            'category' => 'english-literature',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => 'Charles Dickens',
            'option_b' => 'William Shakespeare',
            'option_c' => 'Jane Austen',
            'option_d' => 'Mark Twain',
            'correct_option' => 'B',
            'explanation' => 'William Shakespeare wrote the tragic play "Romeo and Juliet" in the late 16th century.'
        ),
        array(
            'title' => 'What is a synonym for "happy"?',
            'category' => 'english-literature',
            'tags' => array('beginner', 'quick-test'),
            'difficulty' => 'easy',
            'option_a' => 'Sad',
            'option_b' => 'Angry',
            'option_c' => 'Joyful',
            'option_d' => 'Tired',
            'correct_option' => 'C',
            'explanation' => '"Joyful" is a synonym for "happy" as both words describe a positive emotional state.'
        ),
        array(
            'title' => 'Which of these is a noun?',
            'category' => 'english-literature',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => 'Run',
            'option_b' => 'Beautiful',
            'option_c' => 'Book',
            'option_d' => 'Quickly',
            'correct_option' => 'C',
            'explanation' => '"Book" is a noun (a person, place, or thing). The others are a verb, adjective, and adverb respectively.'
        ),
        
        // Current Affairs
        array(
            'title' => 'What is the largest social media platform by users?',
            'category' => 'current-affairs',
            'tags' => array('beginner', 'trivia'),
            'difficulty' => 'easy',
            'option_a' => 'Twitter',
            'option_b' => 'Instagram',
            'option_c' => 'Facebook',
            'option_d' => 'TikTok',
            'correct_option' => 'C',
            'explanation' => 'Facebook (Meta) is currently the largest social media platform with over 2.9 billion monthly active users.'
        ),
        array(
            'title' => 'Which organization awards the Nobel Prize?',
            'category' => 'current-affairs',
            'tags' => array('intermediate', 'educational'),
            'difficulty' => 'medium',
            'option_a' => 'United Nations',
            'option_b' => 'Nobel Foundation',
            'option_c' => 'UNESCO',
            'option_d' => 'World Bank',
            'correct_option' => 'B',
            'explanation' => 'The Nobel Foundation, based in Sweden, is responsible for administering the Nobel Prizes.'
        ),
        
        // Computer Science
        array(
            'title' => 'What does HTML stand for?',
            'category' => 'computer-science',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => 'Hyper Text Markup Language',
            'option_b' => 'High Tech Modern Language',
            'option_c' => 'Home Tool Markup Language',
            'option_d' => 'Hyperlinks and Text Markup Language',
            'correct_option' => 'A',
            'explanation' => 'HTML stands for Hyper Text Markup Language, which is used to create web pages.'
        ),
        array(
            'title' => 'Which programming language is known for web development?',
            'category' => 'computer-science',
            'tags' => array('intermediate', 'professional'),
            'difficulty' => 'medium',
            'option_a' => 'Python',
            'option_b' => 'JavaScript',
            'option_c' => 'C++',
            'option_d' => 'Java',
            'correct_option' => 'B',
            'explanation' => 'JavaScript is primarily known for web development and runs in web browsers to create interactive web pages.'
        ),
        array(
            'title' => 'What does CPU stand for?',
            'category' => 'computer-science',
            'tags' => array('beginner', 'educational'),
            'difficulty' => 'easy',
            'option_a' => 'Central Processing Unit',
            'option_b' => 'Computer Personal Unit',
            'option_c' => 'Central Program Utility',
            'option_d' => 'Computer Processing Utility',
            'correct_option' => 'A',
            'explanation' => 'CPU stands for Central Processing Unit, which is the primary component that executes instructions in a computer.'
        ),
        array(
            'title' => 'Which data structure uses LIFO principle?',
            'category' => 'computer-science',
            'tags' => array('advanced', 'challenging'),
            'difficulty' => 'hard',
            'option_a' => 'Queue',
            'option_b' => 'Stack',
            'option_c' => 'Array',
            'option_d' => 'Linked List',
            'correct_option' => 'B',
            'explanation' => 'Stack uses LIFO (Last In First Out) principle, where the last element added is the first one to be removed.'
        ),
        
        // Sports & Entertainment
        array(
            'title' => 'How many players are there in a football (soccer) team?',
            'category' => 'sports-entertainment',
            'tags' => array('beginner', 'trivia'),
            'difficulty' => 'easy',
            'option_a' => '9',
            'option_b' => '10',
            'option_c' => '11',
            'option_d' => '12',
            'correct_option' => 'C',
            'explanation' => 'A standard football (soccer) team has 11 players on the field at a time.'
        ),
        array(
            'title' => 'Which sport is known as "The Gentleman\'s Game"?',
            'category' => 'sports-entertainment',
            'tags' => array('intermediate', 'trivia'),
            'difficulty' => 'medium',
            'option_a' => 'Tennis',
            'option_b' => 'Golf',
            'option_c' => 'Cricket',
            'option_d' => 'Polo',
            'correct_option' => 'C',
            'explanation' => 'Cricket is traditionally known as "The Gentleman\'s Game" due to its emphasis on fair play and sportsmanship.'
        ),
        array(
            'title' => 'Who directed the movie "Titanic"?',
            'category' => 'sports-entertainment',
            'tags' => array('intermediate', 'fun-facts'),
            'difficulty' => 'medium',
            'option_a' => 'Steven Spielberg',
            'option_b' => 'James Cameron',
            'option_c' => 'Christopher Nolan',
            'option_d' => 'Martin Scorsese',
            'correct_option' => 'B',
            'explanation' => 'James Cameron directed the 1997 blockbuster film "Titanic", which won 11 Academy Awards.'
        ),
        array(
            'title' => 'How many Olympic rings are there?',
            'category' => 'sports-entertainment',
            'tags' => array('beginner', 'quick-test'),
            'difficulty' => 'easy',
            'option_a' => '4',
            'option_b' => '5',
            'option_c' => '6',
            'option_d' => '7',
            'correct_option' => 'B',
            'explanation' => 'The Olympic symbol consists of five interlocking rings, representing the five continents.'
        )
    );
}
