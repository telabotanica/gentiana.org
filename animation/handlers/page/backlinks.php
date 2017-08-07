<?php
/*
backlinks.php
Copyright 2002  Patrick PAUL
Copyright 2003  David DELON
Copyright 2003  Eric FELDSTEIN
Copyright 2003  Jean-Pascal MILCENT
Copyright 2003  Charles NEPOTE
Copyright 2004  Emmanuel Coirier
All rights reserved.
Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the distribution.
3. The name of the author may not be used to endorse or promote products
derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
if (!WIKINI_VERSION) {
     die ("acc&egrave;s direct interdit");
}
echo $this->Header();
?>

<div class="page">

<?php
if ($global = $_REQUEST["global"])
{
	$title = "Pages faisant r&eacute;f&eacute;rence &agrave; ".$this->getPageTag()." :";
}
else
{
	$title = "Pages internes faisant r&eacute;f&eacute;rence &agrave;  ".$this->ComposeLinkToPage($this->GetPageTag())." :";
	//$referrers = $this->LoadReferrers($this->GetPageTag());
}
print("<b>$title</b><br /><br />\n");
	if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
	{
		foreach ($pages as $page)
		{
			print($this->ComposeLinkToPage($page["tag"])."<br />\n");
		}
	}
	else
	{
		print("<i>Aucune page n'a de lien vers ".$this->ComposeLinkToPage($this->getPageTag()).".</i>");
	}
?>
</div>
<?php echo $this->Footer(); ?>
