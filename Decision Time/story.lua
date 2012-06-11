_W = display.contentWidth
_H = display.contentHeight


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
local listener, showPage, webView, removewebview
local cssPath = system.pathForFile( "styles.css", system.ResourceDirectory )



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

-------- File Management ------------
checkForFile.checkForFile("page.html") --checks for page.html and copies it if necesary
checkForFile.checkForFile("db.db") --checks for db.db and copies it if necesary
checkForFile.checkForFile("decision-time.png")


----------Variables--------------
local storyName, storyTopic, page, pageContent
local linklist = "<div id='decision-time'>decision time</div>"

--------- Open styles and write to a file
local fh, reason = io.open( cssPath, "r" )
local style = fh:read("*a")


--local style = ""
local closing = "</body></html>"

------- Functions -----------------


function listener(e)
	if e.type == "link" then
		local urlString = e.url
		local location = string.find(urlString, "#")
		storyboard.page = urlString:sub(location+1)
		storyboard.purgeScene( "story" )
		storyboard.gotoScene( "story" )
	

	end
end

function removewebView()
	if webView then
		webView:removeSelf()
		webView = nil
	linklist = "<div id='decision-time'>decision time</div>"
	end
end

function showPage(id)
	removewebView()
	
	--local count = 0
	local sql = "SELECT * FROM Pages where id = '"..id.."'" 
	
	---Get page content
	for row in storyboard.db:nrows(sql) do 
		--count = count +1
		local text = row.page_content
			-- Get Links
			local getLinks = "Select * from Page_Relations where page_parent = '"..id.."'"
			for links in storyboard.db:nrows(getLinks) do
				linklist = linklist.."<p><a href='#"..links.page_child.."'>"..links.page_link.."</a></p>"
			
			end
		
		
		print(storyboard.storyName..style..text..linklist)
		pageContent = style..text..linklist
		page = io.open( storyboard.path, "w" )
		page:write( style..text..linklist..closing )
		io.close( page )
	end	
	
		
	webView = native.newWebView( 0, 19, _W, _H-88 )
	webView:request( "page.html", system.DocumentsDirectory )
end





-- Called when the scene's view does not exist:
function scene:createScene( event )
	local screenGroup = self.view
	
---------SQL queries------------








	-----------------------------------------------------------------------------
		
	--	CREATE display objects and add them to 'group' here.
	--	Example use-case: Restore 'group' from previously saved state.
	
	-----------------------------------------------------------------------------
	--local hello = display.newRetinaText(pageContent, 40, 40, 300, 500, native.systemFont, 22)
end


-- Called immediately after scene has moved onscreen:
function scene:enterScene( event )
	local group = self.view
		showPage(storyboard.page)
		webView:addEventListener( "urlRequest", listener )

	-----------------------------------------------------------------------------
		
	--	INSERT code here (e.g. start timers, load audio, start listeners, etc.)
	
	-----------------------------------------------------------------------------
	
end


-- Called when scene is about to move offscreen:
function scene:exitScene( event )
	local group = self.view
			--storyboard.destroyScene( "story" )
	removewebView()
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

