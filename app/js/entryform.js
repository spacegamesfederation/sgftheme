var formComplete = false;
var validation = {};
validation.agreeement = false;
validation.game_name = '';
validation.game_desc = '';
validation.team = [];
validation.team_has_minor = false;
validation.team_has_guardian = false;
validation.team_mode = "add";
validation.team_edit = 0;




jQuery(window).bind('beforeunload', function(e) {
	if(formComplete == false){

		if(window.confirm("You have not completed the form, exit anyway?")){
			return false;
		} else {
			 e.preventDefault();
		}
		
	}
});


var $carousel = jQuery('.slideshow');

jQuery('.textfield').on("blur", function() {
   
    console.log(jQuery(this).val());
});

jQuery(document).on('blur', "input.textfield", function() {
    // something
    console.log(jQuery(this).attr("id"), jQuery(this).val());
});

jQuery(".textfield, .textarea, .checkbox").change(function() {
    validateEntry(jQuery(this).attr("id"));
    // Check input( $( this ).val() ) for validity here
});

jQuery("#isMinor input").change(function() {
    if (jQuery('#isMinor input').prop("checked") == true) {
       // console.log('checked isminor');
		validation.team_has_minor
     jQuery('#guardian').addClass('guardian-active');
    } else {
        jQuery('#guardian').removeClass('guardian-active');
    }
});
jQuery("#isGuardian input").change(function() {
    if (jQuery('#isMinor input').prop("checked") == true) {
        console.log('checked isminor');

        jQuery('#add-guardian').addClass('add-guardian-active');
    } else {
        jQuery('#add-guardian').removeClass('add-guardian-active');
    }
});


jQuery(".close").on("click", function() {
    jQuery("#guardian").removeClass("guardian-active");


});


function validateAgreement() {

    var rules = jQuery('#agree-rules input').prop("checked");
    var terms = jQuery('#agree-terms input').prop("checked");
    var privacy = jQuery('#agree-privacy input').prop("checked");

    if (rules === true && terms === true && privacy === true) {
        jQuery("#box_agree").addClass("complete");
        jQuery("#step-agree").addClass("next-active");
        validation.agreeement = true;


    } else {
        jQuery("#box_agree").html("").removeClass("complete");
        jQuery("#step-agree").removeClass("next-active");
        validation.agreeement = false;

    }

}
jQuery("#step-agree").on("click", function() {
    if (validation.agreeement == true) {
        $carousel.slick('slickNext');
    }
});
jQuery("#step-describe").on("click", function() {
    if (validation.game_name != "" && validation.game_desc !== "") {

        $carousel.slick('slickNext');
    }
});
jQuery("#step-materials").on("click", function() {
    jQuery("#box_materials").addClass("complete");
    $carousel.slick('slickNext');

});
jQuery("#step-contact").on("click", function() {
    jQuery("#box_materials").addClass("complete");
    $carousel.slick('slickNext');

});



function notEmpty(id) {
    var val = jQuery("#" + id).val();
    if (val != "") {
        validation[id] = val;
        console.log("text change", id, val);
    }
    if (validation.game_name != "" && validation.game_desc !== "") {
        jQuery("#step-describe").addClass("next-active");
        jQuery("#box_description").addClass("complete");
    } else {
        jQuery("#step-describe").removeClass("next-active");
    }
}

function setTeamMember(member) {
	console.log(member);
	var status = "";
	if(member.isMinor != undefined){
		if (member.isMinor == true) {
				var status = "Under 18";
		}
	}	
	if(member.isGuardian != undefined){
		if (member.isGuardian == true) {
				var status = "Under 18";
		}
	}
	return member.first_name +' '+member.last_name +' | '+member.email +' | '+member.phone +'|'+status;	
}

function displayTeam() {
    var team = validation.team;
    if (team != undefined) {
        console.log("display:", team);

        var display_team = '<div id="team"><ol>';


        for (var m = 0; m < team.length; m++) {

			
            console.log("member", team[m]);

            display_team += '<li class="team-member">';
            display_team += '<span class="team-name">Name: ' + team[m].first_name + ' ' + team[m].last_name + '</span>';
            display_team += '<span class="team-info">Email: ' + team[m].email + '</span>';
            display_team += '<span class="team-info">Phone: ' + team[m].phone + '</span>';
            if (team[m].isMinor == true) {
                display_team += '<span class="team-info">Under 18</span>';

            }
            display_team += '<span class="actions"><a href="#" class="edit" data-edit="' + m + '">Edit</a> <a href="#" class="delete" data-del="' + m + '">Delete</a></span>';


            display_team += '</li>';
			var team_member_info = setTeamMember(team[m]);
			console.log(team_member_info);
			jQuery("#team_member_"+m).val(team_member_info);
        }

        display_team += "<ol></div>";
        jQuery("#display-team").html(display_team);
    }
}

function clearMemberForm(){
	jQuery("#first_name").val("");
	jQuery("#last_name").val("");
	jQuery("#email").val("");
	jQuery("#phone").val("");
	
	jQuery("#isMinor input").attr('checked', false);
	
}

function addMember(member) {
    console.log("add member");
    var team = validation.team;
	var adults = 0;
    if (team.length > 0) {
        console.log("add another member");
        for (var m = 0; m < team.length; m++) {
			if(team[m].isMinor != true){
				adults = 1;
			}
            if (member.email == team[m].email) {
                console.log("dupe");
				jQuery("#email-error").html("Please enter a unique email address");
            } else {
				clearMemberForm();
				if(m == 3 && adults == 0 && member.isMinor == false){
					jQuery("#adult-supervision").html("At least one member of your team must be over 18");
                	//validation.team.push(member);
				}
				if(m == 3 && adults == 0 && member.isMinor == true){
					validation.team.push(member);
                	
				}
				if(adults == 1 && m<3){
					validation.team.push(member);
				}
			}
        }



    } else {
		
        console.log("add first member");
        validation.team.push(member);
		clearMemberForm();
    }
    displayTeam();


}




jQuery(document).delegate("a.edit","click", function(e) {
	e.preventDefault();
	var el = jQuery(this).data('edit');
	
	validation.team_edit = el;
	var team = validation.team[el];
	
	jQuery("#first_name").val(team.first_name);
	jQuery("#last_name").val(team.last_name);
	jQuery("#email").val(team.email);
	jQuery("#phone").val(team.phone);
	
	if(team.isMinor == true){
		jQuery("#isMinor input").attr('checked', true);
	}

	jQuery('#add-member').html('Update Team Member');
	validation.team_mode = 'edit'
	validateMember('update');

});

jQuery(document).delegate("a.delete","click", function(e) {
	e.preventDefault();
	el = jQuery(this).data();
	
	validation.team.splice(el,1);
	
	jQuery(this).parents( ".team-member" ).remove();
	displayTeam();
	clearMemberForm();
	
	

});
function updateMember(member){
	validation.team[validation.team_edit] = member;
	displayTeam();
	//clearMemberForm();

}

function validateMember(action) {
    var first_name = jQuery("#first_name").val();
    var last_name = jQuery("#last_name").val();
	
    var email = jQuery("#email").val();

    var emailValid = validateEmail(email);

    var phone = jQuery("#phone").val();
    var isMinor = jQuery('#isMinor input').prop("checked");


    if (emailValid == false) {
        console.log('email invalid');
        jQuery("#email").addClass("invalid");


    } else {
        jQuery("#email").removeClass("invalid");

    }
    if (first_name != '' && last_name != '' && emailValid == true) {
        var member = {
            "first_name": first_name,
            "last_name": last_name,
            "email": email,
            "phone": phone,
            "isMinor": isMinor,
        };





    }

    switch (action) {

        case "add":
            addMember(member);
            break;
        case "update":
            updateMember(member);
            break;


    }



}


function validateEmail(email) {

    var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

    var filtertest = filter.test(email);

    return filtertest;
}

function validateEntry(id) {
    var el = jQuery(id);

    switch (id) {
        case "agree-rules":
            validateAgreement();
            break;
        case "agree-terms":
            validateAgreement();
            break;
        case "agree-privacy":
            validateAgreement();
            break;
        case "game_name":
            notEmpty(id);
            break;
        case "game_desc":
            notEmpty(id);
            break;




    }
    console.log(validation);




}

jQuery("#add-member, #add-guardian").on("click", function() {
    
	if(validation.team_mode == "add"){
		validateMember("add");
	} else {
	
		validateMember("update");
		clearMemberForm();
		validation.team_mode = "add";
		jQuery('#add-member').html('Add Team Member');
	}

});
jQuery(".edit-member").on("click", function() {
	
    validateMember("update");

});




	
// Word Count for Game Description	
const area = document.getElementById('game_desc');
Countable.on(area, counter => setWordCount(counter.words));

	function setWordCount(words){
		jQuery("#desc_count").html(words+"/500 Words");
		
		if(words<=500){
			jQuery("#desc_count").css("color","#fff");	
		} else {
			jQuery("#desc_count").css("color","#f00");	
			
		}
		
		
	}
	







/******



******/
var gotoslide = function(slide) {
    $('.slideshow').slickGoTo(parseInt(slide));
    console.log(slide);
}
jQuery(document).ready(function() {
    resetStarCanvas();
    jQuery('.slideshow').slick({
        //	autoplay: true,
        dots: false,
        arrows: true,
        infinite: true,
        speed: 1500,
        fade: true,
        cssEase: 'linear',
        focusoOnSelect: true,
        nextArrow: '<i class="slick-arrow slick-next"></i>',
        prevArrow: '<i class="slick-arrow slick-prev"></i>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
					 infinite: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
					 infinite: false,
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    jQuery(".slideshow").css("display", "block");
});

var $carousel = jQuery('.slideshow');
jQuery(document).on('keydown', function(e) {
    if (e.keyCode == 37) {
    ///    $carousel.slick('slickPrev');
    }
    if (e.keyCode == 39) {
        $carousel.slick('slickNext');
    }
    var slideno = jQuery(this).data('slide');
});

jQuery('a[data-slide]').click(function(e) {
    jQuery("#video-subnav ul li a").removeClass("selected-channel");
    jQuery(this).addClass("selected-channel");
    var slideno = jQuery(this).data('slide');
    console.log(slideno);
    $carousel.slick('slickGoTo', slideno);

});


jQuery('.slideshow').on('afterChange', function(event, slick, currentSlide, nextSlide) {
    console.log(currentSlide);
});







