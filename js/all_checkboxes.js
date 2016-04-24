<script type='text/javascript'>
<!-- 	

function SetAllCheckBoxes(CheckValue)
{
var inputElements = document.getElementsByTagName('input');

 

        for (var i = 0 ; i < inputElements.length ; i++) {

            var myElement = inputElements[i];

 

            // Filter through the input types looking for checkboxes

            if (myElement.type === "checkbox") {

 

               // Use the invoker (our calling element) as the reference 

               //  for our checkbox status

                myElement.checked = CheckValue;

            }

        }
}

//  End -->
</script>

