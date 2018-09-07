 class Search{

	constructor(){
		this.resultDiv=$('#search-overlay--result');
		this.openButton=$('.js-search-trigger');
		this.closeButton=$('.search-overlay--close');
		this.searchOverlay=$('.search-overlay');
		this.isOverlayOpen=false;
		this.searchField=$('#search-term');
		this.typingTimer;
		this.isSpinnerVisible=false;
		this.prevValue;
		this.events();
	}
	events(){
		this.openButton.on("click",this.openOverlay.bind(this));
		this.closeButton.on("click",this.closeOverlay.bind(this));
		$(document).on("keydown",this.keyPressDispatcher.bind(this));
		this.searchField.on("keyup",this.typingLogic.bind(this));
	}

	openOverlay(){
		this.searchOverlay.addClass('search-overlay--active');
		$('body').addClass('body-no-scroll');
		setTimeout(function(){
				this.searchField.focus();
		}.bind(this),200);
		this.isOverlayOpen=true;
		return false; //disbale href of <a>
	}

	closeOverlay(){
		this.searchOverlay.removeClass('search-overlay--active');
		$('body').removeClass('body-no-scroll');
		this.isOverlayOpen=false;
	}
	keyPressDispatcher(e){
		
		if(e.keyCode==83 && !this.isOverlayOpen && !$("input,textarea").is(':focus'))
			this.openOverlay();
		if(e.keyCode==27 && this.isOverlayOpen)
			this.closeOverlay();
	}

	typingLogic(){
		if (this.searchField.val()!=this.prevValue) { 
			clearTimeout(this.typingTimer)//resetting Timeout
			if(this.searchField.val()){
				if(!this.isSpinnerVisible){
					this.resultDiv.html("<div class='spinner-loader'></div>");
					this.isSpinnerVisible=true;
				}
				this.typingTimer=setTimeout(this.getAllSearchResult.bind(this),750);
				this.prevValue=this.searchField.val();
			}
			else{
				this.resultDiv.html('');
				this.isSpinnerVisible=false;
			}
			
		}	
	}
/*	getResult(){             //get Post Only
		$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/posts?search='+this.searchField.val(),posts=>{
								//insted of post=> we can use function(){}.bind(this);
				this.resultDiv.html(`
					<h2 class="search-overlay-section-title">Search Results:</h2>
					${posts.length?'<ul class="list-unstyled">':'<p>No general information matches that search</p>'}
						${posts.map(item=>`<li class="pl-5 list-group-item"><a href="${item.link}" class="text-danger">${item.title.rendered}</li>`).join('')}
						
					${posts.length?'</ul>':''}
				`);
		});
		this.isSpinnerVisible=false;
	}*/

	getAllTypeResult(){

		$.when(
			$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/posts?search='+this.searchField.val()),
			$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/pages?search='+this.searchField.val()),
			$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/professors?search='+this.searchField.val()),
			$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/programs?search='+this.searchField.val()),
			$.getJSON(tcsrData.root_url+'/wp-json/wp/v2/events?search='+this.searchField.val())
		).then((posts,pages,professors,programs,events)=>{
			var combinedResults=posts[0].concat(pages[0]).concat(professors[0]).concat(programs[0]).concat(events[0]);
			this.resultDiv.html(`
					<h2 class="search-overlay-section-title">Search Results:</h2>
					${combinedResults.length?'<ul class="list-unstyled">':'<p>No general information matches that search</p>'}
						${combinedResults.map(item=>`<li class="pl-5 list-group-item text-info"><a href="${item.link}" class="text-danger">${item.title.rendered}</a>${item.type=='post'?` by ${item.authorName}`:''}</li>`).join('')}
						
					${combinedResults.length?'</ul>':''}
				`);
		});
		this.isSpinnerVisible=false;

	}

	getAllSearchResult(){

		$.getJSON(tcsrData.root_url+'/wp-json/tcsr/v1/search?term='+this.searchField.val(),(results)=>{
			this.resultDiv.html(`
				<div class="row">
					<div class="col-md-3">
						<h2>General Information</h2>
						${results.generalInfo.length?'<ul class="list-unstyled">':'<p>No general information matches that search</p>'}
						${results.generalInfo.map(item=>`
							<div class="blog_post_detail">
								<div class="blog_post_title">
									<a href="${item.link}">
									${item.title}
									</a>
								</div>
								<div class="blog_post_desc">
									${item.type=='post'?`Post by ${item.authorName}`:''}
									<p class="mb-0">${item.description}</p>
									<a href="${item.link}">Read More</a>
								</div>
							</div>
							`).join('')}
						${results.generalInfo.length?'</ul>':''}
					</div>
					<div class="col-md-3">
						<h2>Programs</h2>
						${results.programs.length?'<ul class="list-unstyled">':`<p>No programs matches that search. <a href="${tcsrData.root_url}/programs">View All Programs</a></p>`}
						${results.programs.map(item=>`<li class="pb-2 text-info"><a href="${item.link}" class="text-danger">${item.title}</a>${item.type=='post'?` by ${item.authorName}`:''}</li>`).join('')}
						${results.programs.length?'</ul>':''}
					</div>
					<div class="col-md-3">
						<h2>Events</h2>
						${results.events.length?'<div class="blog_post col-lg-12 col-md-12">':`<p>No events  matches that search. <a href="${tcsrData.root_url}/events">View All Events</a></p>`}
						${results.events.map(item=>`
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-2 col-2 date_circle" style="padding: 10px;">
								<div class="blog_post_date">
									<span class="post_month">${item.month}</span>
									<span class="post_day">${item.day}</span>
								</div>
							</div>
							<div class="blog_post_detail col-lg-10 col-md-9 col-sm-10 col-10">
								<div class="blog_post_title">
									<a href="${item.link}">
									${item.title}
									</a>
								</div>
								<div class="blog_post_desc">
									${item.description}
									<a href="${item.link}">Read More</a>
								</div>
							</div>
						</div>
						`).join('')}
						${results.events.length?'</div>':''}
					</div>
					<div class="col-md-3">
						<h2>Professors</h2>
						${results.professors.length?'<ul class="list-unstyled">':'<p>No  professors matches that search</p>'}
						
						${results.professors.map(item=>`
							<li class="card prof_card" style="width: 10rem;">
							<a href="<${item.link}" style="text-decoration: none ">
							<div style="overflow: hidden;"><img class="card-img-top" style="width: 100%;" src="${item.image}" alt="Card image cap"></div>
							<div class="card-footer text-center text-danger p-0">${item.title}</div>
							
							</a>
						</li>

						`).join('')}

						${results.professors.length?'</ul>':''}
					</div>
				</div>
			`);

		});
		this.isSpinnerVisible=false;

	}



};

var mySearch=new Search();