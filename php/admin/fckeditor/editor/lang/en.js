/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Chinese Simplified language file.
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

// Toolbar Items and Context Menu
Preview				: "Preview",
Cut					: "Cut",
Copy				: "Copy",
Paste				: "Paste",
PasteText			: "Paste as plain text",
PasteWord			: "Paste from Word",
RemoveFormat		: "Remove Format",
InsertLinkLbl		: "Link",
InsertLink			: "Insert/Edit Link",
RemoveLink			: "Remove Link",
Anchor				: "Insert/Edit Anchor",
AnchorDelete		: "Delete Anchor",
InsertImageLbl		: "Image",
InsertImage			: "Insert/Edit Image",
InsertFlashLbl		: "Flash",
InsertFlash			: "Insert/Edit Flash",
InsertMyCode		: "Insert My HTML",

InsertMedia			: "Media",
InsertAddon			: "Addon",
InsertSsPage		: "分页符",
InsertQuote			: "Quote",
InsertBr			: "Paragraph line breaks",

InsertTableLbl		: "Table",
InsertTable			: "Insert/Edit Table",
InsertLineLbl		: "Line",
InsertLine			: "Insert Horizontal Line",
InsertSmileyLbl		: "Smiley",
InsertSmiley		: "Insert Smiley",
About				: "About FCKeditor",
Bold				: "Bold",
Italic				: "Italic",
Underline			: "Underline",
StrikeThrough		: "Strike Through",
LeftJustify			: "Left Justify",
CenterJustify		: "Center Justify",
RightJustify		: "Right Justify",
BlockJustify		: "Block Justify",
DecreaseIndent		: "Decrease Indent",
IncreaseIndent		: "Increase Indent",
Blockquote			: "Quote Text",
Undo				: "Undo",
Redo				: "Redo",
NumberedListLbl		: "Numbered List",
NumberedList		: "Insert/Remove Numbered List",
BulletedListLbl		: "Bulleted List",
BulletedList		: "Insert/Remove Bulleted List",
ShowDetails			: "Show Details",
Style				: "Style",
FontFormat			: "Format",
Font				: "Font",
FontSize			: "Size",
TextColor			: "Text Color",
BGColor				: "Background Color",
Source				: "Source",
InsertCodes			: "Insert Codes",

FontFormats			: "Normal;Formatted;Address;Heading 1;Heading 2;Heading 3;Heading 4;Heading 5;Heading 6;Normal (DIV)",

// Alerts and Messages
ProcessingXHTML		: "Processing XHTML. Please wait...",
Done				: "Done",
PasteWordConfirm	: "The text you want to paste seems to be copied from Word. Do you want to clean it before pasting?",
NotCompatiblePaste	: "This command is available for Internet Explorer version 5.5 or more. Do you want to paste without cleaning?",
UnknownToolbarItem	: "Unknown toolbar item \"%1\"",
UnknownCommand		: "Unknown command name \"%1\"",
NotImplemented		: "Command not implemented",
UnknownToolbarSet	: "Toolbar set \"%1\" doesn't exist",
NoActiveX			: "Your browser's security settings could limit some features of the editor. You must enable the option \"Run ActiveX controls and plug-ins\". You may experience errors and notice missing features.",
DialogBlocked		: "It was not possible to open the dialog window. Make sure all popup blockers are disabled.",

// Dialogs
DlgBtnOK			: "OK",
DlgBtnCancel		: "Cancel",
DlgBtnClose			: "Close",
DlgAdvancedTag		: "Advanced",
DlgOpOther			: "<Other>",
DlgInfoTab			: "Info",
DlgAlertUrl			: "Please insert the URL",

// General Dialogs Labels
DlgGenNotSet		: "<not set>",

// Image Dialog
DlgImgTitle			: "Image Properties",
DlgImgInfoTab		: "Image Info",
DlgImgURL			: "URL",
DlgImgAlt			: "Alternative Text",
DlgImgWidth			: "Width",
DlgImgHeight		: "Height",
DlgImgBorder		: "Border",
DlgImgHSpace		: "HSpace",
DlgImgVSpace		: "VSpace",
DlgImgAlign			: "Align",
DlgImgAlignLeft		: "Left",
DlgImgAlignAbsBottom: "Abs Bottom",
DlgImgAlignAbsMiddle: "Abs Middle",
DlgImgAlignBaseline	: "Baseline",
DlgImgAlignBottom	: "Bottom",
DlgImgAlignMiddle	: "Middle",
DlgImgAlignRight	: "Right",
DlgImgAlignTextTop	: "Text Top",
DlgImgAlignTop		: "Top",
DlgImgAlertUrl		: "Please type the image URL",

// Flash Dialog
DlgFlashTitle		: "Flash Properties",
DlgFlashChkPlay		: "Auto Play",
DlgFlashChkLoop		: "Loop",
DlgFlashChkMenu		: "Enable Flash Menu",
DlgFlashScale		: "Scale",
DlgFlashScaleAll	: "Show all",
DlgFlashScaleNoBorder	: "No Border",
DlgFlashScaleFit	: "Exact Fit",

// Code Dialog
DlgCodesTitle		: "Insert Codes",
DlgCodesLanguage	: "Language",
DlgCodesContent		: "Content",

// Link Dialog
DlgLnkWindowTitle	: "Link",

DlgMyCodeTitle		: "Insert My HTML",

DlgLnkTarget		: "Target",
DlgLnkTargetBlank	: "New Window (_blank)",
DlgLnkTargetParent	: "Parent Window (_parent)",
DlgLnkTargetSelf	: "Same Window (_self)",
DlgLnkTargetTop		: "Topmost Window (_top)",

DlnLnkMsgNoUrl		: "Please type the link URL",
DlnLnkMsgNoEMail	: "Please type the e-mail address",
DlnLnkMsgNoAnchor	: "Please select an anchor",
DlnLnkMsgInvPopName	: "The popup name must begin with an alphabetic character and must not contain spaces.",

// Color Dialog
DlgColorTitle		: "Select Color",

// Smiley Dialog
DlgSmileyTitle		: "Insert a Smiley",

// Table Dialog
DlgTableTitle		: "Table Properties",
DlgTableRows		: "Rows",
DlgTableColumns		: "Columns",
DlgTableBorder		: "Border size",
DlgTableAlign		: "Alignment",
DlgTableAlignNotSet	: "<Not set>",
DlgTableAlignLeft	: "Left",
DlgTableAlignCenter	: "Center",
DlgTableAlignRight	: "Right",
DlgTableWidth		: "Width",
DlgTableWidthPx		: "pixels",
DlgTableWidthPc		: "percent",
DlgTableHeight		: "Height",
DlgTableCellSpace	: "Cell spacing",
DlgTableCellPad		: "Cell padding",
DlgTableCaption		: "Caption",
DlgTableSummary		: "Summary",

// Paste Operations / Dialog
PasteErrorCut	: "Your browser security settings don't permit the editor to automatically execute cutting operations. Please use the keyboard for that (Ctrl+X).",
PasteErrorCopy	: "Your browser security settings don't permit the editor to automatically execute copying operations. Please use the keyboard for that (Ctrl+C).",

PasteAsText		: "Paste as Plain Text",
PasteFromWord	: "Paste from Word",

DlgPasteMsg2	: "Please paste inside the following box using the keyboard (<strong>Ctrl+V</strong>) and hit <strong>OK</strong>.",
DlgPasteSec		: "Because of your browser security settings, the editor is not able to access your clipboard data directly. You are required to paste it again in this window.",
DlgPasteIgnoreFont		: "Ignore Font Face definitions",
DlgPasteRemoveStyles	: "Remove Styles definitions",

// Color Picker
ColorAutomatic	: "Automatic",

// Anchor Dialog
DlgAnchorTitle		: "Anchor Properties",
DlgAnchorName		: "Anchor Name",
DlgAnchorErrorName	: "Please type the anchor name",

// About Dialog
DlgAboutAboutTab	: "About",
DlgAboutInfo		: "For further information go to"

};
