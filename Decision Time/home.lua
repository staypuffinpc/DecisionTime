----------------------------------------------------------------------------------
--
-- scenetemplate.lua
--
----------------------------------------------------------------------------------

local storyboard = require( "storyboard" )
local scene = storyboard.newScene()
local widget = require "widget"
local sqlite = require "sqlite3" --get sqlite library
local checkForFile = require "checkForFile"

_W = display.contentWidth
_H = display.contentHeight

--storyboard.path = system.pathForFile( "page.html", system.DocumentsDirectory) -- path to 
--storyboard.pathToDB = system.pathForFile("db.db",system.DocumentsDirectory); --path to sqlite db
--storyboard.db = sqlite.open(storyboard.pathToDB); --open db

local storyList

----------------------------------------------------------------------------------
-- 
--	NOTE:
--	
--	Code outside of listener functions (below) will only be executed once,
--	unless storyboard.removeScene() is called.
-- 
---------------------------------------------------------------------------------

---------------------------------------------------------------------------------
-- BEGINNING OF YOUR IMPLEMENTATION
---------------------------------------------------------------------------------

-- Called when the scene's view does not exist:
function scene:createScene( event )
	local group = self.view
	--local box = display.newText("Home", 0, 50, 200, 300, system.nativeFont, 35)
	--group:insert(box)
	
	local headerHomeBG = display.newRect(0,0,_W,38)
headerHomeBG:setFillColor(76,108,151)
	group:insert(headerHomeBG)
	group.x = 0; group.y = 0;

local headerHomeTXT = display.newEmbossedText("Decision Time", 0, 500, 500, 10, native.systemFont, 26)
headerHomeTXT:setTextColor(255,255,255)
headerHomeTXT:setReferencePoint(display.TopLeftReferencePoint)
headerHomeTXT.x = (_W-headerHomeTXT.width)/2
headerHomeTXT.y = 3
group:insert(headerHomeTXT)

local sql = "Select * from Stories"

local count = 1

for stories in storyboard.db:nrows(sql) do
	storyList = storyList.."<a href='#"..stories.story_id.."'>"..stories.story_name.."</a>"
	
end

listOfStories = io.open( storyboard.pathToStories, "w" )
listOfStories:write( storyList )
io.close( listOfStories )

webView = native.newWebView( 0, 19, _W, _H-88 )
webView:request( "page.html", system.DocumentsDirectory )


-- Called immediately after scene has moved onscreen:
function scene:enterScene( event )
	local group = self.view
	
	-----------------------------------------------------------------------------
		
	--	INSERT code here (e.g. start timers, load audio, start listeners, etc.)
	
	-----------------------------------------------------------------------------
	
end


-- Called when scene is about to move offscreen:
function scene:exitScene( event )
	local group = self.view
	webView:addEventListener( "urlRequest", listener )

	-----------------------------------------------------------------------------
	
	--	INSERT code here (e.g. stop timers, remove listeners, unload sounds, etc.)
	
	-----------------------------------------------------------------------------
	
end


-- Called prior to the removal of scene's "view" (display group)
function scene:destroyScene( event )
	local group = self.view
	
	-----------------------------------------------------------------------------
	
	--	INSERT code here (e.g. remove listeners, widgets, save state, etc.)
	
	-----------------------------------------------------------------------------
	
end


---------------------------------------------------------------------------------
-- END OF YOUR IMPLEMENTATION
---------------------------------------------------------------------------------

-- "createScene" event is dispatched if scene's view does not exist
scene:addEventListener( "createScene", scene )

-- "enterScene" event is dispatched whenever scene transition has finished
scene:addEventListener( "enterScene", scene )

-- "exitScene" event is dispatched before next scene's transition begins
scene:addEventListener( "exitScene", scene )

-- "destroyScene" event is dispatched before view is unloaded, which can be
-- automatically unloaded in low memory situations, or explicitly via a call to
-- storyboard.purgeScene() or storyboard.removeScene().
scene:addEventListener( "destroyScene", scene )

---------------------------------------------------------------------------------

return scene