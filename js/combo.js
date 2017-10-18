
$(function()
{

	$("#projectId").change(function()
	{
		var projectId = $("#projectId").val();
		var $sUserName = $("input[name='sUserName']");
       
             $.ajax
		  ({
			    type:"POST",
			    url:"/ser/user/finduserproject/"+projectId,
			    dataType:"json",
			    success:function(res)
			    {
					console.log(res);
                    $sUserName.val( res.sUserName );
                 
			    }

		  });
         
        
		 
        

	});
});




