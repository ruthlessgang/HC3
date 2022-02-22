<div id="formsubmitbutton">
<input type="submit" name="submitter" value="Submit Button" onclick="ButtonClicked()">
</div>
<div id="buttonreplacement" style="margin-left:30px; display:none;">
<img src="/images/loading.gif" alt="loading...">
</div>

<script type="text/javascript">
function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("buttonreplacement").style.display = ""; // to display
   return true;
}
var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;
</script>

