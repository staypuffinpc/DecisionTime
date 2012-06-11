// Force Paste Plain Text plugin for HTMLArea
// Modified version of Paste-Text plugin for HTMLArea

// Distributed under the same terms as HTMLArea itself.
// This notice MUST stay intact for use (see license.txt).

function PlainText(editor) {
  this.editor = editor;
	var cfg = editor.config;
	var self = this;

	editor.config.htmlareaPaste =true;
}

PlainText._pluginInfo = {
	name          : "PlainText",
	version       : "0.1",
	developer     : "Steve Exley",
	developer_url : "http://www.steveonamission.com",
	c_owner       : "",
	sponsor       : "",
	sponsor_url   : "",
	license       : "htmlArea"
};

HTMLArea.prototype.pasteArea = function() {
	var editor = this;
	outparam = {
		
	}; 
	html=" ";
	editor._popupDialog( "plugin://PasteText/paste_text", function( html ) {
		html = html.replace(/</g, "&lt;");
  		html = html.replace(/>/g, "&gt;");
		html = html.replace(/\t/g,"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		html = html.replace(/\n/g,"</p><p>");
		html="<p>"+html;
		editor.insertHTML(html);
	}, outparam);
};

// the execCommand function (intercepts some commands and replaces them with
// our own implementation)
HTMLArea.prototype.execCommand = function(cmdID, UI, param)
{
  var editor = this;	// for nested functions
  this.focusEditor();
  cmdID = cmdID.toLowerCase();
  // @todo : useCSS is deprecated, see ticket #619
  if ( HTMLArea.is_gecko )
  {
    try
    {
      this._doc.execCommand('useCSS', false, true); //switch useCSS off (true=off)
    } catch (ex) {}
  }
  switch (cmdID)
  {
    case "htmlmode":
      this.setMode();
    break;

    case "hilitecolor":
    case "forecolor":
      this._colorSelector(cmdID);
    break;

    case "createlink":
      this._createLink();
    break;

    case "undo":
    case "redo":
      if (this._customUndo)
      {
        this[cmdID]();
      }
      else
      {
        this._doc.execCommand(cmdID, UI, param);
      }
    break;

    case "inserttable":
      this._insertTable();
    break;

    case "insertimage":
      this._insertImage();
    break;

    case "about":
      this._popupDialog(editor.config.URIs.about, null, this);
    break;

    case "showhelp":
      this._popupDialog(editor.config.URIs.help, null, this);
    break;

    case "killword":
      this._wordClean();
    break;
    
	case "cut":
    case "copy":

    try
    {
      this._doc.execCommand(cmdID, UI, param);
      if ( this.config.killWordOnPaste )
      {
        this._wordClean();
      }
    }
    catch (ex)
    {
      if ( HTMLArea.is_gecko )
      {
		// this possibly isn't the right warning for this error
        alert(HTMLArea._lc("The Paste button does not work in Mozilla based web browsers (technical security reasons). Press CTRL-V on your keyboard to paste directly."));
      }
    }
    break;

    case "paste":
    try
    {
      //this._doc.execCommand(cmdID, UI, param);
      var pastehtml=clipboardData.getData("Text"); //paste everything in IE as plain text!
      this.insertHTML(pastehtml);
      if ( this.config.killWordOnPaste )
      {
        this._wordClean();
      }
    }
    catch (ex)
    {
      if ( HTMLArea.is_gecko )
      {
		this.pasteArea();
      }
    }
    break;
    case "lefttoright":
    case "righttoleft":
      var dir = (cmdID == "righttoleft") ? "rtl" : "ltr";
      var el = this.getParentElement();
      while ( el && !HTMLArea.isBlockElement(el) )
      {
        el = el.parentNode;
      }
      if ( el )
      {
        if ( el.style.direction == dir )
        {
          el.style.direction = "";
        }
        else
        {
          el.style.direction = dir;
        }
      }
    break;
    default:
      try
      {
        this._doc.execCommand(cmdID, UI, param);
      }
      catch(ex)
      {
        if ( this.config.debug )
        {
          alert(e + "\n\nby execCommand(" + cmdID + ");");
        }
      }
    break;
  }

  this.updateToolbar();
  
  return false;
};