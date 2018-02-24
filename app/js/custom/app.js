function iframeSrc(target, url) {
    console.log(target, url);
    jQuery(target).attr('src', url);
}

function setEntry(id) {

    console.log(id);

    jQuery('#entry').html(jQuery('#entry' + id).html());
}

jQuery(document).ready(function() {
    jQuery('input[type=radio][name=vote]').change(function() {
        jQuery('#vote_rank').val(this.value);
    });
});


jQuery(function() {
    jQuery("#sortable").sortable({
        placeholder: "ui-state-highlight",
        receive: function(event, ui) {
            console.log(this, event, ui, jQuery(this));
        }
    });
    jQuery("#sortable").disableSelection();
});

jQuery("#sortable").on("sortstop", function(event, ui) {

    var counter = 1;
    var ranking = '\n';
    jQuery("#sortable li").each(function(li, i) {
        var entry = jQuery(this).attr("title");
        var id = jQuery(this).attr('id');
        console.log(id);
        jQuery('#' + id + " span.rank").html(counter + ". ");
        ranking += counter + "." + entry + "\n";

        counter++;

    });





    console.log(ranking);

    jQuery('#vote_rank').val(ranking);



});



var formComplete = false;
var validation = {};
validation.agreeement = false;
validation.game_name = '';
validation.game_desc = '';
validation.file_upload = '';
validation.video_url = '';
validation.team = [];
validation.team_has_minor = false;
validation.team_has_guardian = false;
validation.team_mode = "add";
validation.team_edit = 0;




jQuery(window).bind('beforeunload', function(e) {
    /*if(formComplete == false){

    //  if(window.confirm("You have not completed the form, exit anyway?")){
            return false;
        } else {
             e.preventDefault();
        }
        
    }*/
});


var $carousel = jQuery('.slideshow');


jQuery(".textfield, .textarea, .checkbox, .upload").change(function() {
    validateEntry(jQuery(this).attr("id"));
    previewEntry();
    // Check input( $( this ).val() ) for validity here
});
jQuery(".textarea").on("click", function() {
    validateEntry(jQuery(this).attr("id"));
    previewEntry();
    // Check input( $( this ).val() ) for validity here
});

jQuery("#isMinor input").change(function() {
    if (jQuery('#isMinor input').prop("checked") == true) {
        // console.log('checked isminor');
        //validation.team_has_minor
        jQuery('#guardian').addClass('guardian-active');
    } else {
        jQuery('#guardian').removeClass('guardian-active');
    }
});
jQuery("#isGuardian input").change(function() {
    if (jQuery('#isMinor input').prop("checked") == true) {
        //        console.log('checked isminor');

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
jQuery(".last-step").on("click", function() {
    $carousel.slick('slickPrev');

});
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
jQuery("#step-team").on("click", function() {
    //jQuery("#box_materials").addClass("complete");
    $carousel.slick('slickNext');

});

function previewEntry() {

    var v = validation;
    //console.log("preview",v);
    jQuery("#entry-name").html("<strong>Game Name:</strong> " + v.game_name);
    jQuery("#entry-description").html("<strong>Game Descripton:</strong> " + v.game_desc);
    jQuery("#entry-video-url").html(v.video_url);
    jQuery("#entry-upload-file").html(v.file_upload.replace(/^.*[\\\/]/, ''));
    var team = validation.team;
    var adults = 0;
    var team_list = "<h3>Your Space Game Entry:</h3>";
    team_list = "<ul>";

    if (team.length > 0) {
        //console.log("add another member");
        for (var m = 0; m < team.length; m++) {
            var minor = '';
            if (isMinor == true) {
                minor = "Under 18";
            }

            team_list += '<li><strong>Name: </strong> ';
            team_list += team[m].first_name + ' ' + team[m].last_name + '<br>';
            team_list += '<strong>Email: </strong>:' + team[m].email + '<br>';
            team_list += '<strong>Phone: </strong>' + team[m].phone + '<br>';



            team_list += minor + '';
            team_list += '</li>';
        }

    }
    team_list += "</ul>";
    //console.log(team_list);
    jQuery("#entry-team-list").html(team_list);

}




function notEmpty(id) {
    var val = jQuery("#" + id).val();
    if (val != "") {
        validation[id] = val;
        //      console.log("text change", id, val);
    }
    if (validation.game_name != "" && validation.game_desc !== "") {
        jQuery("#step-describe").addClass("next-active");
        jQuery("#box_description").addClass("complete");
    } else {
        jQuery("#step-describe").removeClass("next-active");
    }
}



function setTeamMember(member) {
    //console.log(member);
    var status = "";
    if (member.isMinor != undefined) {
        if (member.isMinor == true) {
            status = "Under 18";
        }
    }
    if (member.isGuardian != undefined) {
        if (member.isGuardian == true) {
            status = "Under 18";
        }
    }
    return member.first_name + ' ' + member.last_name + ' | ' + member.email + ' | ' + member.phone + '|' + status;
}

function displayTeam() {
    var team = validation.team;
    if (team != undefined) {
        //        console.log("display:", team);

        var display_team = '<div id="team"><ol>';


        for (var m = 0; m < team.length; m++) {


            //            console.log("member", team[m]);

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
            //          console.log(team_member_info);
            jQuery("#team_member_" + m).val(team_member_info);
        }

        display_team += "<ol></div>";
        jQuery("#display-team").html(display_team);
    }
}

function clearMemberForm() {
    jQuery("#first_name").val("");
    jQuery("#last_name").val("");
    jQuery("#email").val("");
    jQuery("#phone").val("");

    jQuery("#isMinor input").attr('checked', false);

}

function addMember(member) {
    //console.log("add member");
    if (member != undefined) {
        var team = validation.team;
        console.log(validation.team);
        var adults = 0;
        if (team.length > 0) {

            for (var m = 0; m < team.length; m++) {
                /*      */
                if (team[m].isMinor != true) {
                    adults = 1;
                }
                if (member.email == team[m].email) {
                    // console.log("dupe");
                    //  jQuery("#email-error").html("Please enter a unique email address");
                } else {
                    clearMemberForm();
                    if (m == 3 && adults == 0 && member.isMinor == false) {
                        //console.log("fifth member is not an adult");
                        jQuery("#adult-supervision").html("At least one member of your team must be over 18");
                        validation.team.push(member);
                    }
                    if (m == 3 && adults == 0 && member.isMinor == true) {
                        //  console.log("can't add fifth minor");

                        jQuery("#adult-supervision").html("At least one member of your team must be over 18");
                        validation.team.push(member);
                    }
                    if (adults == 1 && m < 3) {
                        validation.team.push(member);
                    }
                }

            }



        } else {
            //console.log("add first member");

            validation.team.push(member);

            jQuery("#step-team").addClass("next-active");
            clearMemberForm();
        }

        displayTeam();
        jQuery("#box_contact").addClass("complete");
    }

}




jQuery(document).delegate("a.edit", "click", function(e) {
    e.preventDefault();
    var el = jQuery(this).data('edit');

    validation.team_edit = el;
    var team = validation.team[el];

    jQuery("#first_name").val(team.first_name);
    jQuery("#last_name").val(team.last_name);
    jQuery("#email").val(team.email);
    jQuery("#phone").val(team.phone);

    if (team.isMinor == true) {
        jQuery("#isMinor input").attr('checked', true);
    }

    jQuery('#add-member').html('Update Team Member');
    validation.team_mode = 'edit';
    validateMember('update');

});

jQuery(document).delegate("a.delete", "click", function(e) {
    e.preventDefault();
    el = jQuery(this).data();

    validation.team.splice(el, 1);
    console.log(validation.team);
    jQuery(this).parents(".team-member").remove();
    clearMemberForm();
    previewEntry();


});

function updateMember(member) {
    validation.team[validation.team_edit] = member;
    displayTeam();
    //clearMemberForm();

}

function validateMember(action) {
    var first_name = jQuery("#first_name").val();
    var last_name = jQuery("#last_name").val();
    var member = {};
    var email = jQuery("#email").val();

    var emailValid = true; //validateEmail(email);

    var phone = jQuery("#phone").val();
    var isMinor = jQuery('#isMinor input').prop("checked");


    if (emailValid == false) {
        // console.log('email invalid');
        jQuery("#email").addClass("invalid");


    } else {
        jQuery("#email").removeClass("invalid");

    }
    if (first_name != '' && last_name != '' && emailValid == true) {
        member = {
            "first_name": first_name,
            "last_name": last_name,
            "email": email,
            "phone": phone,
            "isMinor": isMinor,
        };





    } else {
        return;
    }

    switch (action) {

        case "add":
            addMember(member);
            previewEntry();
            break;
        case "update":
            updateMember(member);
            previewEntry();
            break;


    }



}

function validateVideoURL(id) {
    var url = jQuery("#" + id).val();
    var a = url.match("/http:\/\/(?:www.)?(?:(vimeo).com\/(.*)|(youtube).com\/watch\?v=(.*?)&)/");


    if (a == "youtube") {
        validation[id] = url;

        previewEntry();

        // do stuff
    } else if (a == "vimeo") {
        validation[id] = url;
        previewEntry();
        // do stuff
    } else {
        jQuery('video_url_message').html("Please Enter a valid Vimeo or YouTube URL");
        //validation[id] = "not valid";
        previewEntry();
        // Not a valid url
    }
    validation[id] = url;
    previewEntry();


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

        case "video_url":

            validateVideoURL(id);
            break;

        case "file_upload":
            var filename = jQuery("#file_upload").val();
            validation[id] = filename;
            //console.log("filename",filename);

            break;

    }
    //console.log(validation);


}

jQuery("#add-member").on("click", function() {

    if (validation.team_mode == "add") {
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

jQuery(window).resize(function() {
    resetStarCanvas();


});

function resetStarCanvas() {
    jQuery("#stars canvas").css("width", jQuery(window).width());
    jQuery("#stars canvas").css("height", jQuery(window).height());
}


var countries = [
    { name: 'Afghanistan', code: 'AF' },
    { name: 'Ã…land Islands', code: 'AX' },
    { name: 'Albania', code: 'AL' },
    { name: 'Algeria', code: 'DZ' },
    { name: 'American Samoa', code: 'AS' },
    { name: 'Andorra', code: 'AD' },
    { name: 'Angola', code: 'AO' },
    { name: 'Anguilla', code: 'AI' },
    { name: 'Antarctica', code: 'AQ' },
    { name: 'Antigua and Barbuda', code: 'AG' },
    { name: 'Argentina', code: 'AR' },
    { name: 'Armenia', code: 'AM' },
    { name: 'Aruba', code: 'AW' },
    { name: 'Australia', code: 'AU' },
    { name: 'Austria', code: 'AT' },
    { name: 'Azerbaijan', code: 'AZ' },
    { name: 'Bahamas', code: 'BS' },
    { name: 'Bahrain', code: 'BH' },
    { name: 'Bangladesh', code: 'BD' },
    { name: 'Barbados', code: 'BB' },
    { name: 'Belarus', code: 'BY' },
    { name: 'Belgium', code: 'BE' },
    { name: 'Belize', code: 'BZ' },
    { name: 'Benin', code: 'BJ' },
    { name: 'Bermuda', code: 'BM' },
    { name: 'Bhutan', code: 'BT' },
    { name: 'Bolivia', code: 'BO' },
    { name: 'Bosnia and Herzegovina', code: 'BA' },
    { name: 'Botswana', code: 'BW' },
    { name: 'Bouvet Island', code: 'BV' },
    { name: 'Brazil', code: 'BR' },
    { name: 'British Indian Ocean Territory', code: 'IO' },
    { name: 'Brunei Darussalam', code: 'BN' },
    { name: 'Bulgaria', code: 'BG' },
    { name: 'Burkina Faso', code: 'BF' },
    { name: 'Burundi', code: 'BI' },
    { name: 'Cambodia', code: 'KH' },
    { name: 'Cameroon', code: 'CM' },
    { name: 'Canada', code: 'CA' },
    { name: 'Cape Verde', code: 'CV' },
    { name: 'Cayman Islands', code: 'KY' },
    { name: 'Central African Republic', code: 'CF' },
    { name: 'Chad', code: 'TD' },
    { name: 'Chile', code: 'CL' },
    { name: 'China', code: 'CN' },
    { name: 'Christmas Island', code: 'CX' },
    { name: 'Cocos (Keeling) Islands', code: 'CC' },
    { name: 'Colombia', code: 'CO' },
    { name: 'Comoros', code: 'KM' },
    { name: 'Congo', code: 'CG' },
    { name: 'Congo, The Democratic Republic of the', code: 'CD' },
    { name: 'Cook Islands', code: 'CK' },
    { name: 'Costa Rica', code: 'CR' },
    { name: 'Cote D\'Ivoire', code: 'CI' },
    { name: 'Croatia', code: 'HR' },
    { name: 'Cuba', code: 'CU' },
    { name: 'Cyprus', code: 'CY' },
    { name: 'Czech Republic', code: 'CZ' },
    { name: 'Denmark', code: 'DK' },
    { name: 'Djibouti', code: 'DJ' },
    { name: 'Dominica', code: 'DM' },
    { name: 'Dominican Republic', code: 'DO' },
    { name: 'Ecuador', code: 'EC' },
    { name: 'Egypt', code: 'EG' },
    { name: 'El Salvador', code: 'SV' },
    { name: 'Equatorial Guinea', code: 'GQ' },
    { name: 'Eritrea', code: 'ER' },
    { name: 'Estonia', code: 'EE' },
    { name: 'Ethiopia', code: 'ET' },
    { name: 'Falkland Islands (Malvinas)', code: 'FK' },
    { name: 'Faroe Islands', code: 'FO' },
    { name: 'Fiji', code: 'FJ' },
    { name: 'Finland', code: 'FI' },
    { name: 'France', code: 'FR' },
    { name: 'French Guiana', code: 'GF' },
    { name: 'French Polynesia', code: 'PF' },
    { name: 'French Southern Territories', code: 'TF' },
    { name: 'Gabon', code: 'GA' },
    { name: 'Gambia', code: 'GM' },
    { name: 'Georgia', code: 'GE' },
    { name: 'Germany', code: 'DE' },
    { name: 'Ghana', code: 'GH' },
    { name: 'Gibraltar', code: 'GI' },
    { name: 'Greece', code: 'GR' },
    { name: 'Greenland', code: 'GL' },
    { name: 'Grenada', code: 'GD' },
    { name: 'Guadeloupe', code: 'GP' },
    { name: 'Guam', code: 'GU' },
    { name: 'Guatemala', code: 'GT' },
    { name: 'Guernsey', code: 'GG' },
    { name: 'Guinea', code: 'GN' },
    { name: 'Guinea-Bissau', code: 'GW' },
    { name: 'Guyana', code: 'GY' },
    { name: 'Haiti', code: 'HT' },
    { name: 'Heard Island and Mcdonald Islands', code: 'HM' },
    { name: 'Holy See (Vatican City State)', code: 'VA' },
    { name: 'Honduras', code: 'HN' },
    { name: 'Hong Kong', code: 'HK' },
    { name: 'Hungary', code: 'HU' },
    { name: 'Iceland', code: 'IS' },
    { name: 'India', code: 'IN' },
    { name: 'Indonesia', code: 'ID' },
    { name: 'Iran, Islamic Republic Of', code: 'IR' },
    { name: 'Iraq', code: 'IQ' },
    { name: 'Ireland', code: 'IE' },
    { name: 'Isle of Man', code: 'IM' },
    { name: 'Israel', code: 'IL' },
    { name: 'Italy', code: 'IT' },
    { name: 'Jamaica', code: 'JM' },
    { name: 'Japan', code: 'JP' },
    { name: 'Jersey', code: 'JE' },
    { name: 'Jordan', code: 'JO' },
    { name: 'Kazakhstan', code: 'KZ' },
    { name: 'Kenya', code: 'KE' },
    { name: 'Kiribati', code: 'KI' },
    { name: 'Korea, Democratic People\'S Republic of', code: 'KP' },
    { name: 'Korea, Republic of', code: 'KR' },
    { name: 'Kuwait', code: 'KW' },
    { name: 'Kyrgyzstan', code: 'KG' },
    { name: 'Lao People\'S Democratic Republic', code: 'LA' },
    { name: 'Latvia', code: 'LV' },
    { name: 'Lebanon', code: 'LB' },
    { name: 'Lesotho', code: 'LS' },
    { name: 'Liberia', code: 'LR' },
    { name: 'Libyan Arab Jamahiriya', code: 'LY' },
    { name: 'Liechtenstein', code: 'LI' },
    { name: 'Lithuania', code: 'LT' },
    { name: 'Luxembourg', code: 'LU' },
    { name: 'Macao', code: 'MO' },
    { name: 'Macedonia, The Former Yugoslav Republic of', code: 'MK' },
    { name: 'Madagascar', code: 'MG' },
    { name: 'Malawi', code: 'MW' },
    { name: 'Malaysia', code: 'MY' },
    { name: 'Maldives', code: 'MV' },
    { name: 'Mali', code: 'ML' },
    { name: 'Malta', code: 'MT' },
    { name: 'Marshall Islands', code: 'MH' },
    { name: 'Martinique', code: 'MQ' },
    { name: 'Mauritania', code: 'MR' },
    { name: 'Mauritius', code: 'MU' },
    { name: 'Mayotte', code: 'YT' },
    { name: 'Mexico', code: 'MX' },
    { name: 'Micronesia, Federated States of', code: 'FM' },
    { name: 'Moldova, Republic of', code: 'MD' },
    { name: 'Monaco', code: 'MC' },
    { name: 'Mongolia', code: 'MN' },
    { name: 'Montserrat', code: 'MS' },
    { name: 'Morocco', code: 'MA' },
    { name: 'Mozambique', code: 'MZ' },
    { name: 'Myanmar', code: 'MM' },
    { name: 'Namibia', code: 'NA' },
    { name: 'Nauru', code: 'NR' },
    { name: 'Nepal', code: 'NP' },
    { name: 'Netherlands', code: 'NL' },
    { name: 'Netherlands Antilles', code: 'AN' },
    { name: 'New Caledonia', code: 'NC' },
    { name: 'New Zealand', code: 'NZ' },
    { name: 'Nicaragua', code: 'NI' },
    { name: 'Niger', code: 'NE' },
    { name: 'Nigeria', code: 'NG' },
    { name: 'Niue', code: 'NU' },
    { name: 'Norfolk Island', code: 'NF' },
    { name: 'Northern Mariana Islands', code: 'MP' },
    { name: 'Norway', code: 'NO' },
    { name: 'Oman', code: 'OM' },
    { name: 'Pakistan', code: 'PK' },
    { name: 'Palau', code: 'PW' },
    { name: 'Palestinian Territory, Occupied', code: 'PS' },
    { name: 'Panama', code: 'PA' },
    { name: 'Papua New Guinea', code: 'PG' },
    { name: 'Paraguay', code: 'PY' },
    { name: 'Peru', code: 'PE' },
    { name: 'Philippines', code: 'PH' },
    { name: 'Pitcairn', code: 'PN' },
    { name: 'Poland', code: 'PL' },
    { name: 'Portugal', code: 'PT' },
    { name: 'Puerto Rico', code: 'PR' },
    { name: 'Qatar', code: 'QA' },
    { name: 'Reunion', code: 'RE' },
    { name: 'Romania', code: 'RO' },
    { name: 'Russian Federation', code: 'RU' },
    { name: 'RWANDA', code: 'RW' },
    { name: 'Saint Helena', code: 'SH' },
    { name: 'Saint Kitts and Nevis', code: 'KN' },
    { name: 'Saint Lucia', code: 'LC' },
    { name: 'Saint Pierre and Miquelon', code: 'PM' },
    { name: 'Saint Vincent and the Grenadines', code: 'VC' },
    { name: 'Samoa', code: 'WS' },
    { name: 'San Marino', code: 'SM' },
    { name: 'Sao Tome and Principe', code: 'ST' },
    { name: 'Saudi Arabia', code: 'SA' },
    { name: 'Senegal', code: 'SN' },
    { name: 'Serbia and Montenegro', code: 'CS' },
    { name: 'Seychelles', code: 'SC' },
    { name: 'Sierra Leone', code: 'SL' },
    { name: 'Singapore', code: 'SG' },
    { name: 'Slovakia', code: 'SK' },
    { name: 'Slovenia', code: 'SI' },
    { name: 'Solomon Islands', code: 'SB' },
    { name: 'Somalia', code: 'SO' },
    { name: 'South Africa', code: 'ZA' },
    { name: 'South Georgia and the South Sandwich Islands', code: 'GS' },
    { name: 'Spain', code: 'ES' },
    { name: 'Sri Lanka', code: 'LK' },
    { name: 'Sudan', code: 'SD' },
    { name: 'Suriname', code: 'SR' },
    { name: 'Svalbard and Jan Mayen', code: 'SJ' },
    { name: 'Swaziland', code: 'SZ' },
    { name: 'Sweden', code: 'SE' },
    { name: 'Switzerland', code: 'CH' },
    { name: 'Syrian Arab Republic', code: 'SY' },
    { name: 'Taiwan, Province of China', code: 'TW' },
    { name: 'Tajikistan', code: 'TJ' },
    { name: 'Tanzania, United Republic of', code: 'TZ' },
    { name: 'Thailand', code: 'TH' },
    { name: 'Timor-Leste', code: 'TL' },
    { name: 'Togo', code: 'TG' },
    { name: 'Tokelau', code: 'TK' },
    { name: 'Tonga', code: 'TO' },
    { name: 'Trinidad and Tobago', code: 'TT' },
    { name: 'Tunisia', code: 'TN' },
    { name: 'Turkey', code: 'TR' },
    { name: 'Turkmenistan', code: 'TM' },
    { name: 'Turks and Caicos Islands', code: 'TC' },
    { name: 'Tuvalu', code: 'TV' },
    { name: 'Uganda', code: 'UG' },
    { name: 'Ukraine', code: 'UA' },
    { name: 'United Arab Emirates', code: 'AE' },
    { name: 'United Kingdom', code: 'GB' },
    { name: 'United States', code: 'US' },
    { name: 'United States Minor Outlying Islands', code: 'UM' },
    { name: 'Uruguay', code: 'UY' },
    { name: 'Uzbekistan', code: 'UZ' },
    { name: 'Vanuatu', code: 'VU' },
    { name: 'Venezuela', code: 'VE' },
    { name: 'Viet Nam', code: 'VN' },
    { name: 'Virgin Islands, British', code: 'VG' },
    { name: 'Virgin Islands, U.S.', code: 'VI' },
    { name: 'Wallis and Futuna', code: 'WF' },
    { name: 'Western Sahara', code: 'EH' },
    { name: 'Yemen', code: 'YE' },
    { name: 'Zambia', code: 'ZM' },
    { name: 'Zimbabwe', code: 'ZW' }
];