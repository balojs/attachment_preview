# Attachment Preview
An [osTicket](https://github.com/osTicket/osTicket) plugin allowing inlining of Attachments


Simply `git clone https://github.com/clonemeagain/attachment_preview.git /includes/plugins/attachment_preview`
Or extract [latest-zip](https://github.com/clonemeagain/attachment_preview/archive/master.zip) into /includes/plugins/attachment_preview

Navigate to: https://your.domain/support/scp/plugins.php?a=add to add a new plugin.

1. Click "Install" next to "Attachment Inline Plugin"
1. Now the plugin needs to be enabled & configured, so you should be seeing the list of currently installed plugins, pick the checkbox next to "Attachment Inline Plugin" and select the "Enable" button.
1. Now you can configure the plugin, click the link "Attachment Inline Plugin" and choose who the plugin should be activated for, or keep the default.


To remove the plugin, simply return to the admin plugins view, click the checkbox and push the "Delete" button.

The plugin will still be available, you have deleted the config only at this point, to remove after deleting, remove the /plugins/attachment_preview folder.


#How it looks:

![agent_view](https://cloud.githubusercontent.com/assets/5077391/15166401/bedd01fc-1761-11e6-8814-178c7d4efc03.png)


# How it works:

It's pretty simple, when configured to work, and a tickets page is viewer, an output buffer is created on BootStrap which waits for the page to be finished rendering by osTicket.
When that's done, we flush the buffer and put the structure into a DOMDocument, pretty standard PHP so far.
We run through the link elements of the Document, see which are Attachments.
If we have admin permission to "inline the attachment", we add a new DOMElement after the attachments section, inlining the attachment. PDF's become `<object>`'s, PNG's become `<img>` etc. 
Tested and works on 1.8-git. SHOULD work on future versions, depending on how the files are attached.. haven't tested on anything else though, let me know! 
The plugin is self-contained, so ZERO MODS to core are required. You simply clone the repo or download the zip from github and extract into /includes/plugins/ which should make a folder: "attachment_preview", but it could be called anything. 

Current features:
- PDF Files attached to a thread entry (note/message/reply etc) are embedded as full PDF objects in the entry.
- Images attached to a thread entry are inserted as normal <img> tags.
-- png
-- jpg
-- gif
-- svg
-- bmp
- Text files attached to a thread entry are fetched via AJAX and inserted into the thread entry using <pre> (If enabled). 
- HTML files are also fetched via AJAX and inserted (If enabled). 
- All modifications to the DOM are now performed on the server
- Admin can choose the types of attachments to inline, and who can inline them.
- Default admin options are embed "PDF's & Images" only for "Agents". 


TODO:
- Put CSS into a file
- I was thinking, onInstall dump the CSS into /css/ or something
- Then onUninstall simply remove the file.. could work. Assumes web-server has write permission to the entire osTicket install though, so have simply inlined all CSS changes.
