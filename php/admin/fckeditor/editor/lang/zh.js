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
Preview				: "預覽",
Cut					: "剪切",
Copy				: "復制",
Paste				: "粘貼",
PasteText			: "粘貼為無格式文本",
PasteWord			: "從 MS Word 粘貼",
RemoveFormat		: "清除格式",
InsertLinkLbl		: "超鏈接",
InsertLink			: "插入/編輯超鏈接",
RemoveLink			: "取消超鏈接",
Anchor				: "插入/編輯錨點鏈接",
AnchorDelete		: "清除錨點鏈接",
InsertImageLbl		: "圖象",
InsertImage			: "插入/編輯圖象",
InsertFlashLbl		: "Flash",
InsertFlash			: "插入/編輯 Flash",
InsertMyCode			: "插入我定義的HTML",

InsertMedia			: "多媒體",
InsertAddon			: "附件",
InsertSsPage			: "分頁符",
InsertQuote			: "引用",
InsertBr			: "段內換行符",

InsertTableLbl		: "表格",
InsertTable			: "插入/編輯表格",
InsertLineLbl		: "水平線",
InsertLine			: "插入水平線",
InsertSmileyLbl		: "表情符",
InsertSmiley		: "插入表情圖標",
About				: "關於 FCKeditor",
Bold				: "加粗",
Italic				: "傾斜",
Underline			: "下劃線",
StrikeThrough		: "刪除線",
LeftJustify			: "左對齊",
CenterJustify		: "居中對齊",
RightJustify		: "右對齊",
BlockJustify		: "兩端對齊",
DecreaseIndent		: "減少縮進量",
IncreaseIndent		: "增加縮進量",
Blockquote			: "引用文字",
Undo				: "撤消",
Redo				: "重做",
NumberedListLbl		: "編號列表",
NumberedList		: "插入/刪除編號列表",
BulletedListLbl		: "項目列表",
BulletedList		: "插入/刪除項目列表",
ShowDetails			: "顯示詳細資料",
Style				: "樣式",
FontFormat			: "格式",
Font				: "字體",
FontSize			: "大小",
TextColor			: "文本顏色",
BGColor				: "背景顏色",
Source				: "源代碼",
InsertCodes			: "插入代碼",

FontFormats			: "普通;已編排格式;地址;標題 1;標題 2;標題 3;標題 4;標題 5;標題 6;段落(DIV)",

// Alerts and Messages
ProcessingXHTML		: "正在處理 XHTML，請稍等...",
Done				: "完成",
PasteWordConfirm	: "您要粘貼的內容好像是來自 MS Word，是否要清除 MS Word 格式後再粘貼？",
NotCompatiblePaste	: "該命令需要 Internet Explorer 5.5 或更高版本的支持，是否按常規粘貼進行？",
UnknownToolbarItem	: "未知工具欄項目 \"%1\"",
UnknownCommand		: "未知命令名稱 \"%1\"",
NotImplemented		: "命令無法執行",
UnknownToolbarSet	: "工具欄設置 \"%1\" 不存在",
NoActiveX			: "瀏覽器安全設置限制了本編輯器的某些功能。您必須啟用安全設置中的“運行 ActiveX 控件和插件”，否則將出現某些錯誤並缺少功能。",
DialogBlocked		: "無法打開對話框窗口，請確認是否啟用了禁止彈出窗口或網頁對話框（IE）。",

// Dialogs
DlgBtnOK			: "確定",
DlgBtnCancel		: "取消",
DlgBtnClose			: "關閉",
DlgAdvancedTag		: "高級",
DlgOpOther			: "<其它>",
DlgInfoTab			: "信息",
DlgAlertUrl			: "請插入 URL",

// General Dialogs Labels
DlgGenNotSet		: "<沒有設置>",

// Image Dialog
DlgImgTitle			: "圖象屬性",
DlgImgInfoTab		: "圖象",
DlgImgURL			: "源文件",
DlgImgAlt			: "替換文本",
DlgImgWidth			: "寬度",
DlgImgHeight		: "高度",
DlgImgBorder		: "邊框大小",
DlgImgHSpace		: "水平間距",
DlgImgVSpace		: "垂直間距",
DlgImgAlign			: "對齊方式",
DlgImgAlignLeft		: "左對齊",
DlgImgAlignAbsBottom: "絕對底邊",
DlgImgAlignAbsMiddle: "絕對居中",
DlgImgAlignBaseline	: "基線",
DlgImgAlignBottom	: "底邊",
DlgImgAlignMiddle	: "居中",
DlgImgAlignRight	: "右對齊",
DlgImgAlignTextTop	: "文本上方",
DlgImgAlignTop		: "頂端",
DlgImgAlertUrl		: "請輸入圖象地址",

// Flash Dialog
DlgFlashTitle		: "Flash 屬性",
DlgFlashChkPlay		: "自動播放",
DlgFlashChkLoop		: "循環",
DlgFlashChkMenu		: "啟用Flash菜單",
DlgFlashScale		: "縮放",
DlgFlashScaleAll	: "全部顯示",
DlgFlashScaleNoBorder	: "無邊框",
DlgFlashScaleFit	: "嚴格匹配",

// Code Dialog
DlgCodesTitle		: "插入代碼",
DlgCodesLanguage	: "語言",
DlgCodesContent		: "內容",

// Link Dialog
DlgLnkWindowTitle	: "超鏈接",

DlgMyCodeTitle			: "插入我定義的HTML",

DlgLnkTarget		: "目標",
DlgLnkTargetBlank	: "新窗口 (_blank)",
DlgLnkTargetParent	: "父窗口 (_parent)",
DlgLnkTargetSelf	: "本窗口 (_self)",
DlgLnkTargetTop		: "整頁 (_top)",

DlnLnkMsgNoUrl		: "請輸入超鏈接地址",
DlnLnkMsgNoEMail	: "請輸入電子郵件地址",
DlnLnkMsgNoAnchor	: "請選擇一個錨點",
DlnLnkMsgInvPopName	: "彈出窗口名稱必須以字母開頭，並且不能含有空格。",

// Color Dialog
DlgColorTitle		: "選擇顏色",

// Smiley Dialog
DlgSmileyTitle		: "插入表情圖標",

// Table Dialog
DlgTableTitle		: "表格屬性",
DlgTableRows		: "行數",
DlgTableColumns		: "列數",
DlgTableBorder		: "邊框",
DlgTableAlign		: "對齊",
DlgTableAlignNotSet	: "<沒有設置>",
DlgTableAlignLeft	: "左對齊",
DlgTableAlignCenter	: "居中",
DlgTableAlignRight	: "右對齊",
DlgTableWidth		: "寬度",
DlgTableWidthPx		: "像素",
DlgTableWidthPc		: "百分比",
DlgTableHeight		: "高度",
DlgTableCellSpace	: "間距",
DlgTableCellPad		: "邊距",
DlgTableCaption		: "標題",
DlgTableSummary		: "摘要",

// Paste Operations / Dialog
PasteErrorCut	: "您的瀏覽器安全設置不允許編輯器自動執行剪切操作，請使用鍵盤快捷鍵(Ctrl+X)來完成。",
PasteErrorCopy	: "您的瀏覽器安全設置不允許編輯器自動執行復制操作，請使用鍵盤快捷鍵(Ctrl+C)來完成。",

PasteAsText		: "粘貼為無格式文本",
PasteFromWord	: "從 MS Word 粘貼",

DlgPasteMsg2	: "請使用鍵盤快捷鍵(<STRONG>Ctrl+V</STRONG>)把內容粘貼到下面的方框裏，再按 <STRONG>確定</STRONG>。",
DlgPasteSec		: "因為你的瀏覽器的安全設置原因，本編輯器不能直接訪問你的剪貼板內容，你需要在本窗口重新粘貼一次。",
DlgPasteIgnoreFont		: "忽略 Font 標簽",
DlgPasteRemoveStyles	: "清理 CSS 樣式",

// Color Picker
ColorAutomatic	: "自動",

// Anchor Dialog
DlgAnchorTitle		: "命名錨點",
DlgAnchorName		: "錨點名稱",
DlgAnchorErrorName	: "請輸入錨點名稱",

// About Dialog
DlgAboutAboutTab	: "關於",
DlgAboutInfo		: "要獲得更多信息請訪問 "

};
