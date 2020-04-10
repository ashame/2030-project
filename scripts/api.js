function fetchBusinesses(term, location) {
    let businesses = [];
    let query = `{
        search  (term: "${term}",
                 location: "${location}") {
                     total
                     business {
                         name
                         rating
                         location {
                            address1
                            city
                            state
                        }
                        hours {
                            is_open_now
                            open {
                                day
                                start
                                end
                            }
                        }
                        phone
                    }
                }
    }`
    $.ajax({
        type: "POST",
        url: "database/api.php",
        data: "query=" + query,
        success: function (response) {
            let json = JSON.parse(response);
            for (let index in json.data.search.business) {
                businesses.push(json.data.search.business[index]);
            }
        },
    })
    return businesses;
}

$(document).ready(function () {
    $(".lr-form").submit(function (e) {
        e.preventDefault();
        $(this).fadeOut();
        let businesses = fetchBusinesses($(this).find("input[name='query']").val(), ($(this).find("input[name='location']").val()));
        setTimeout(function () { // w h y   d o e s   t h i s   n o t   l O a D 
            let cards = [];
            for (let i = 0; i < businesses.length; i++) {
                let business = businesses[i];
                let card = $("<div class='card'></div>");
                let name = $(`<h1 class="businessName">${business.name}</h1>`);
                let rating = $(`<span class="rating">${business.rating}</span>`);
                let location = $(`<span class="location">${business.location.city}, ${business.location.state}</span>`);
                let controls = $("<div class='cardControls'></div>");
                let accept = $("<button class='accept'>Yes</button>");
                let decline = $("<button class='decline'>No</button>");
                decline.click(function () {
                    $(this).parent().parent().fadeOut();
                })
                accept.click(function () {
                    if (card.find(".businessInfo").length == 0) {
                        let info = $("<div class='businessInfo'></div>");
                        info.html(`
                        <label>Address</label> <span>${business.location.address1}</span>
                        <label>Tel</label> <span>${business.phone}</span>
                        <label>Status</label> <span>${business.hours[0].is_open_now ? "Open Now!" : "Closed"}</span>
                    `);
                        card.append(info);
                    }
                    $(this).html("Close");
                    $(this).click(function () {
                        $(this).parent().parent().fadeOut();
                    })
                })

                controls.append(accept);
                controls.append(decline);

                card.append(name);
                card.append(rating);
                card.append(location);
                card.append(controls);

                cards.push(card);
            }
            let container = $("<div class='cardContainer'></div>");
            cards.forEach((card) => container.prepend(card));
            container.find('.card').first().find(".decline").click(function() {
                let form = $(".lr-form");
                form.find("input").val("");
                $(".lr-form").fadeIn("fast");
            });
            $(".container").append(container);
        }, 1000);
    })
});