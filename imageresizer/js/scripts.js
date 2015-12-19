// Empty JS for your own code to be here

     $(function() {
 
   // getElementById
	function $id(id) {
		return document.getElementById(id);
	}


    var dropZone = document.getElementById('drop-zone');
    var uploadForm = document.getElementById('upload-form');

	// output information
	function Output(msg) {
		var m = $id("drop-zone");
		m.innerHTML = msg + m.innerHTML;
	}
   

    $("#submit").submit(function(e){
    
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length)>6){
         alert("You can only upload a maximum of 6 files");
        }
        else
        {
        	$("#upload-form").submit();
        }
    });    

   // output file information
	function ParseFile(file) {

		Output(
			"<p>File information: <strong>" + file.name +
			"</strong> type: <strong>" + file.type +
			"</strong> size: <strong>" + file.size +
			"</strong> bytes</p>"
		);

	}
   

    dropZone.ondrop = function(e) {
    	
        e.preventDefault();
        e.stopPropagation();  
        	// fetch FileList object
		var files = e.target.files || e.dataTransfer.files;
		var temp = document.getElementById("fileToUpload").files ;

        document.getElementById("fileToUpload").files = files;
		// process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f);
		}
    }

    dropZone.ondragover = function(e) {
    	
    	 e.preventDefault();
      //  this.className = 'upload-drop-zone drop';
        return false;
    }

    dropZone.ondragleave = function(e) {
    	 e.preventDefault();
      
        //this.className = 'upload-drop-zone';
        return false;
    }

});
