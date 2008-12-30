/*
 * JsMin
 * Javascript Compressor
 * http://www.crockford.com/
 * http://www.smallsharptools.com/
*/

dp.sh.Brushes.Shell=function()
{var funcs=' aaa bbb';var keywords='ccc ddd';var operators='null ';this.regexList=[{regex:new RegExp('#(.*)$','gm'),css:'comment'},{regex:dp.sh.RegexLib.DoubleQuotedString,css:'string'},{regex:dp.sh.RegexLib.SingleQuotedString,css:'string'},{regex:new RegExp(this.GetKeywords(funcs),'gmi'),css:'func'},{regex:new RegExp(this.GetKeywords(operators),'gmi'),css:'op'},{regex:new RegExp(this.GetKeywords(keywords),'gmi'),css:'keyword'}];this.CssClass='dp-Shell';this.Style='.dp-Shell .func { color: #ff1493; }'+'.dp-Shell .op { color: #808080; }';}
dp.sh.Brushes.Shell.prototype=new dp.sh.Highlighter();dp.sh.Brushes.Shell.Aliases=['shell'];
