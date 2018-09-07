class Like{
	constructor(){
		this.events();
	}
	events(){
		$('#like-box').on('click',this.ourClickDispatcher.bind(this));
	}
	ourClickDispatcher(e){
		var currentLikeBox=$(e.target).closest('#like-box');
		//console.log(currentLikeBox.attr('data-exists'));
		if(currentLikeBox.attr('data-exists')=="yes"){
			this.deleteLike(currentLikeBox);
		}
		else{
			this.createLike(currentLikeBox);
		}
	}
	createLike(currentLikeBox){
		$.ajax({
			beforeSend: function (xhr) {
        		xhr.setRequestHeader( 'X-WP-Nonce', tcsrData.nonce );
    		},
			url: tcsrData.root_url+'/wp-json/tcsr/v1/manageLike',
			type:'POST',
			data:{'professorID':currentLikeBox.data('professor')},
			success:(response)=>{
				console.log(response);
				currentLikeBox.attr('data-exists','yes');
				var likeCount=parseInt(currentLikeBox.find('.like-count').html());
				likeCount++;
				currentLikeBox.find('.like-count').html(likeCount);
				currentLikeBox.attr('data-like',response);
			},
			error:(response)=>{
				console.log(response);
				if(response.responseText=="guest"){
					toastr.error('Sorry! Please Login to Like Professor');
				}
			}
		});
	}

	deleteLike(currentLikeBox){
		$.ajax({
			beforeSend: function (xhr) {
        		xhr.setRequestHeader( 'X-WP-Nonce', tcsrData.nonce );
    		},
			url: tcsrData.root_url+'/wp-json/tcsr/v1/manageLike',
			type:'DELETE',
			data:{'like':currentLikeBox.attr('data-like')},
			success:(response)=>{
				console.log(response);
				currentLikeBox.attr('data-exists','no');
				var likeCount=parseInt(currentLikeBox.find('.like-count').html());
				likeCount--;
				currentLikeBox.find('.like-count').html(likeCount);
				currentLikeBox.attr('data-like','');
			},
			error:(response)=>{

				console.log(response);
				if(response.responseText){
					toastr.error(response.responseText);
				}
			}
		});
	}

};

var mylike=new Like();