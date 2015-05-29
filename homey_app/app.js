"use strict";
  
var jayson = require('jayson'),
    fs     = require('fs'),
    http   = require('http');

var ANIMATIONS = {
    "confirm": require('./animations/bevestiging.js'),
    "searching": require('./animations/boodschappen_noemen.js')
};

function App() { }

module.exports = App;

var shoppinglist = [];

var CONFIG = JSON.parse(fs.readFileSync("./config.json")),
    client = jayson.client.https(CONFIG.RPC);

var say = function(text) {
    Homey.log(text);
    Homey.manager('speech-output').say(text);
};

var addToShoppingList = function (items) {
    Homey.manager('ledring').animate(ANIMATIONS.searching);

    items.forEach(function (item) {

        var amount = 1;
        var name = item;

        // Determine whether the item starts with a number, if so
        // it should be added multiple times
        var split_item = item.split(' ');
        if (split_item.length > 1) {
            if (!isNaN(parseInt(split_item[0]))) {
                amount = parseInt(split_item[0]);
                split_item.splice(0, 1);
                name = split_item.join(' ');
            }
        }

        // Do RPC request
        client.request("search", {query: name}, function (err, error, response) {
            if (response) {
                if (amount == 1) {
                    say(response.name + " is toegevoegd aan je boodschappenlijstje.");
                } else {
                    say(amount + " keer " + response.name + " zijn toegevoegd aan je boodschappenlijstje.");
                }

                // Add found product to shopping list
                response.amount = amount;
                shoppinglist.push(response);
            } else {
                say("Dat kon ik helaas niet vinden.");
            }

            Homey.manager('ledring').animate(ANIMATIONS.confirm);
        });
    });
}

App.prototype.init = function() {

};

App.prototype.speech = function( speech ) {

    var sentence = speech.transcript;

    // Words to filter from the input string
    var filter = [
        "zet", "op", "het", "boodschappenlijstje",
        "ik", "wil", "vanavond", "eten", "voeg",
        "toe", "aan", "boodschappen", "wat", "staat",
        "er", "mijn", "is", "de", "een", "ook", "graag",
        "morgen", "drinken", "keer"
    ];

    sentence = " " + sentence + " ";

    filter.forEach(function (word) {
        sentence = sentence.replace(" " + word + " ", " ");
    });

    sentence = sentence.trim();

    // Enable adding multiple items at once
    var items = sentence.split(' en ');

    // Items list is empty, user probably requested what is
    // on the shopping list.
    if (items.length == 1 && items[0].length == 0) {
        if (shoppinglist.length == 0) {
            say("Je boodschappenlijstje is leeg.");
        } else {
            say("Op je boodschappenlijstje staan nu:");

            shoppinglist.forEach( function (item) {
                if (item.amount == 1) {
                    say(item.name + ", " + item.unit);
                } else {
                    say(item.amount + " keer " + item.name + ", " + item.unit);
                }
            });
        }
    } else {
        // Items were found, add them to shopping list
        say(items);
        addToShoppingList(items);
    }
};

// HTTP server, just because we can
var http = require('http');
http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});

    var content = "";

    if (shoppinglist.length == 0) {
        content += "Je boodschappenlijstje is leeg.";
    }

    shoppinglist.forEach(function (item) {
        if (item.amount == 1) {
            content += (item.name + ", " + item.unit + "\n");
        } else {
            content += (item.amount + " keer " + item.name + ", " + item.unit + "\n");
        }
    });

    res.end(content);
}).listen(1337);

String.prototype.trim = function () {
    return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}
