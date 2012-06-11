----- Hides the status bar ----------
display.setStatusBar( display.HiddenStatusBar )

------- Libraries ------------------
local storyboard = require "storyboard"
local widget = require "widget"
local sqlite = require "sqlite3" --get sqlite library
local checkForFile = require "checkForFile"
--local scrollview = require "scrollview"


-------- File Management ------------
checkForFile.checkForFile("page.html") --checks for page.html and copies it if necesary
checkForFile.checkForFile("db.db") --checks for db.db and copies it if necesary
checkForFile.checkForFile("stories.html")
-- Paths

----- Global variables --------------
_W = display.contentWidth
_H = display.contentHeight
local headerBG, headerTXT, header, tabs

storyboard.story = 1
storyboard.path = system.pathForFile( "page.html", system.DocumentsDirectory) -- path to 
storyboard.pathToDB = system.pathForFile("db.db",system.DocumentsDirectory); --path to sqlite db
storyboard.pathToStories = system.pathForFile("stories.html", system.DocumentsDirectory)
storyboard.db = sqlite.open(storyboard.pathToDB); --open db
local tabButtons

------Functions -----------------------
local function onSystemEvent(e)
	if(e.type == "applicationExit") then
		storyboard.db:close();
	end
end

local function onBtnPress(e)
	if tabButtons[e.target.id].scene == "home" then
		print("home")
		header.isVisible = false
		--tabs.isVisible = false
		storyboard.gotoScene(tabButtons[e.target.id].scene, "slideLeft", 800)
	else
		print("not home")
		header.isVisible = true
		--tabs.isVisible = true
		storyboard.gotoScene(tabButtons[e.target.id].scene, "slideLeft", 800)
	end
end

------Get informtion about the DB ------
local sql = "Select * from Stories where story_id = '"..storyboard.story.."'"
for storyInfo in storyboard.db:nrows(sql) do
	storyboard.storyName = storyInfo.story_name
	storyboard.storyTopic = storyInfo.story_topic
	print("storyName: "..storyboard.storyName)
	storyboard.page = storyInfo.story_first_page
end

-- load scenetemplate.lua
storyboard.gotoScene( "home" )

--------------Status Bar----------------------
header = display.newGroup()
headerBG = display.newRect(0,0,_W,38)
headerBG:setFillColor(76,108,151)


headerTXT = display.newEmbossedText(storyboard.storyTopic..": "..storyboard.storyName, 0, 0, 0, 0, native.systemFont, 26)
headerTXT:setTextColor(255,255,255)
headerTXT:setReferencePoint(display.TopLeftReferencePoint)
headerTXT.x = (_W-headerTXT.width)/2
headerTXT.y = 3

header:insert(headerBG)
header:insert(headerTXT)






---------------Tabbar ------------------------


tabButtons = {
    	 {
            label="Home",
            up="appImages/home.png",
            down="appImages/home-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            selected=true,
			scene = "home",
           
        },
    
    
        {
            label="Story",
            up="appImages/story.png",
            down="appImages/story-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "story",
        },
        {
            label="Glossary",
            up="appImages/glossary.png",
            down="appImages/glossary-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "glossary",
        },
        {
            label="Answers",
            up="appImages/answers.png",
            down="appImages/answers-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "answers",
        },
        {
            label="Project Map",
            up="appImages/map.png",
            down="appImages/map-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "map",
        },
        {
            label="Summary",
            up="appImages/summary.png",
            down="appImages/summary-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "summary",
        },
        {
            label="Quiz",
            up="appImages/quiz.png",
            down="appImages/quiz-blue.png",
            width=32, height=32,
            onPress=onBtnPress,
            scene = "quiz",
        },
    }

tabs = widget.newTabBar{
        top=_H-50,
        buttons=tabButtons
    }

--header.isVisible = false
--tabs.isVisible = false
-------Event Listeners --------------    
    
Runtime:addEventListener("system", onSystemEvent);
