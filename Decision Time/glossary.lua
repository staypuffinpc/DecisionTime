_W = display.contentWidth
_H = display.contentHeight


----------------------------------------------------------------------------------
--
-- scenetemplate.lua
--
----------------------------------------------------------------------------------

local storyboard = require( "storyboard" )
local storyboard = require "storyboard"
local widget = require "widget"
local sqlite = require "sqlite3" --get sqlite library
local scene = storyboard.newScene()
local scrollView, group, termdisplay, termList
storyboard.db = sqlite.open(storyboard.pathToDB); --open db


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
	--local background = display.newRect(0, 38, _W, _H)
	--background:setFillColor(255, 255, 255)
	--group:insert(background)
	--local box = display.newText("Glossary", 0, 50, 200, 300, system.nativeFont, 35)
	--group:insert(box)
	count = 1
scrollView = widget.newScrollView{ height=_H-88, top=38, maskFile="mask-320x320.png" }


local function termList()
	local sql = "Select * from Terms where story = '"..storyboard.story.."'"
	for terms in storyboard.db:nrows(sql) do
		term = terms.term
		definition = terms.definition
		print(term..definition)
		
		termdisplay = display.newText(term, 0, 0, 0, 0, native.systemFont, 18)
		termdisplay:setTextColor(0, 0, 0)
		termdisplay:setReferencePoint(display.TopLeftReferencePoint)
		termdisplay.x = 50
		termdisplay.y = count*24
		termdisplay.height = 24
		--termdisplay.width = 300
		scrollView:insert(termdisplay)
		count = count + 1
	end

end
		termList()
		group.y = 38
		--group:insert(scrollView.view)

	-----------------------------------------------------------------------------
		
	--	CREATE display objects and add them to 'group' here.
	--	Example use-case: Restore 'group' from previously saved state.
	
	-----------------------------------------------------------------------------
	
end


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