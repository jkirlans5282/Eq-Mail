
//var credentials =
//      {
//        "url": "https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false",
//        "username": "f14b9d0b-3ced-45c7-98c3-99ed0ec9e96f",
//        "password": "4ibDVHnNjoUW"
//      }

/*
var request = $.ajax({
  type: "POST",
  url: "https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false",
  //username:"f14b9d0b-3ced-45c7-98c3-99ed0ec9e96f",
  //password:"4ibDVHnNjoUW",
  xhrFields: {
    // The 'xhrFields' property sets additional fields on the XMLHttpRequest.
    // This can be used to set the 'withCredentials' property.
    // Set the value to 'true' if you'd like to pass cookies to the server.
    // If this is enabled, your server must respond with the header
    // 'Access-Control-Allow-Credentials: true'.
    withCredentials: true
  },
  beforeSend:function(xhr){
  xhr.setRequestHeader("Authorization", "Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==") //Some characters have been replaced for security but this is a true BASE64 of "username:password"
  },
  headers:{
    "Accept":"application/json",
    "Content-Type":"text/plain",
    "Accept-Language":"en",
    "Content-Language":"en",
    //"Origin": "chrome-extension://hnpoidiplkboebhfnmfhelmcbfdlomnn",
    //"Cookie": "Watson-DPAT=SjN4c0RUS2FnMHB0QWdhcDl5WUV5ejdFc2RSRDZBN0hVRjFTanAwenpCdTlZeHF3UmZrMzNzeEVodHV4a25pWGRlREtPVXZDZDZMODIydXNoc2lyZmNReDUwUmJpOFh6djNOTk54TVlYMXVxTTZlOE1kYitqNTNzVm1qbXJLOSt3SnhNczZMNmdWejVVNTRWNmhBZXRQM2R6MXVxUGs3MGJDbjZNaDJENXJRWTFOenp1KytSZms3bDc4ZStCVlFEcFpQQXVRWjNwbk1ETTA2d2tNNVBxUEJkN3VZdkYraDNoTjV4dUpyTm5IY3Y1V1RscFBqKzhaUFZ2UmZxQzh5dFpJeHRmdkJ6UEdwUGFRN0ViQ0xJeU1COG96SmJNbkY2VUdOWmVBVTdPTWdKZ3JFZUxVRDIzRTlFc3U4K2xwRW4yYmpES0p4ZmtiMUFDU0hVM2tHclhNb0hkakplaG0ycEpseG92VVo4bS9BPQ=="

    //"Authorization":"Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw=="
  },
  data:"xtending pharmaceutical patents beyond the current 20 years will prevent generic drug production forcing patients to pay more for the same medication. This disincentives investment in research and development of new and better drugs, and at a time when drug companies already spend 1.5-2 times more on marketing, then on R&D, it is foolish to further desincentivize the advancement of life saving drugs. We need more effective drugs not more expensive ones. These high costs will also preven",
  //success: success,
  dataType: "json"
});
*/
// Create the XHR object.
function createCORSRequest(method, url) {
  var xhr = new XMLHttpRequest();
  if ("withCredentials" in xhr) {
    // XHR for Chrome/Firefox/Opera/Safari.
    xhr.open(method, url, true);
  } else if (typeof XDomainRequest != "undefined") {
    // XDomainRequest for IE.
    xhr = new XDomainRequest();
    xhr.open(method, url);
  } else {
    // CORS not supported.
    xhr = null;
  }
  return xhr;
}

// Helper method to parse the title tag from the response.
function getTitle(text) {
  return text.match('<title>(.*)?</title>')[1];
}

// Make the actual CORS request.
function makeCorsRequest() {
  // All HTML5 Rocks properties support CORS.
  var url = 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false';

  var xhr = createCORSRequest('POST', url);
  if (!xhr) {
    alert('CORS not supported');
    return;
  }

  // Response handlers.
  xhr.onload = function() {
    var text = xhr.responseText;
    var title = getTitle(text);
    alert('Response from CORS request to ' + url + ': ' + title);
  };

  xhr.onerror = function() {
    alert('Woops, there was an error making the request.');
  };

  xhr.send();
}




*/

/*

var request = $.ajax({
  type:"POST",
  url:"https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false",
  headers:{
  //POST /personality-insights/api/v2/profile?header=false HTTP/1.1
  "Host": "gateway.watsonplatform.net",
  "Connection": "keep-alive",
  "Content-Length": "958",
  "Authorization": "Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==",
  "Accept-Language": "en",
  "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36",
  "Content-Language": "en",
  "Content-Type": "text/plain",
  "Accept": "application/json",  
  "Cache-Control": "no-cache",
  "Accept-Encoding": "gzip, deflate",
  "Cookie": "Watson-DPAT=SjN4c0RUS2FnMHB0QWdhcDl5WUV5ejdFc2RSRDZBN0hVRjFTanAwenpCdTlZeHF3UmZrMzNzeEVodHV4a25pWGRlREtPVXZDZDZMODIydXNoc2lyZmNReDUwUmJpOFh6djNOTk54TVlYMXVxTTZlOE1kYitqNTNzVm1qbXJLOSt3SnhNczZMNmdWejVVNTRWNmhBZXRQM2R6MXVxUGs3MGJDbjZNaDJENXJRWTFOenp1KytSZms3bDc4ZStCVlFEcFpQQXVRWjNwbk1ETTA2d2tNNVBxUEJkN3VZdkYraDNoTjV4dUpyTm5IY3Y1V1RscFBqKzhaUFZ2UmZxQzh5dFpJeHRmdkJ6UEdwUGFRN0ViQ0xJeU1COG96SmJNbkY2VUdOWmVBVTdPTWdKZ3JFZUxVRDIzRTlFc3U4K2xwRW4yYmpES0p4ZmtiMUFDU0hVM2tHclhNb0hkakplaG0ycEpseG92VVo4bS9BPQ=="
  },
  data:"As a constituent, consumer, and tech user, I am deeply concerned about the provisions that are being written into the Trans-Pacific Partnership (TPP) and other trade agreements being negotiated by the Office of the United States Trade Representative. I oppose \u201ctrade\u201d policies that are developed without proper oversight or input from the public. The shear fact that wikileaks was the source to provide the full text of the bill should indicate that TPP outlines laws which are NOT in the best interests of the general public, since the laws had to be hidden from the public. TPP contains clauses which are unacceptable. These clauses will extend pharmaceutical drug patents, restrict internet freedoms, and create a legal framework for companies to sue nations over potential profit loss.f user created content which TPP seeks to destroy. For more information and arguments which are presented better then mine check out www.citizens.org and www.eff.org",
  dataType:"json"
  
  //curl 'https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false' -H 'Authorization: Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw==' -H 'Origin: chrome-extension://fdmmgilgnpjigdojojpjoooidkmcomcm' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: en' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' -H 'Content-Language: en' -H 'Accept: application/json' -H 'Cache-Control: no-cache' -H 'Cookie: Watson-DPAT=SjN4c0RUS2FnMHB0QWdhcDl5WUV5ejdFc2RSRDZBN0hVRjFTanAwenpCdTlZeHF3UmZrMzNzeEVodHV4a25pWGRlREtPVXZDZDZMODIydXNoc2lyZmNReDUwUmJpOFh6djNOTk54TVlYMXVxTTZlOE1kYitqNTNzVm1qbXJLOSt3SnhNczZMNmdWejVVNTRWNmhBZXRQM2R6MXVxUGs3MGJDbjZNaDJENXJRWTFOenp1KytSZms3bDc4ZStCVlFEcFpQQXVRWjNwbk1ETTA2d2tNNVBxUEJkN3VZdkYraDNoTjV4dUpyTm5IY3Y1V1RscFBqKzhaUFZ2UmZxQzh5dFpJeHRmdkJ6UEdwUGFRN0ViQ0xJeU1COG96SmJNbkY2VUdOWmVBVTdPTWdKZ3JFZUxVRDIzRTlFc3U4K2xwRW4yYmpES0p4ZmtiMUFDU0hVM2tHclhNb0hkakplaG0ycEpseG92VVo4bS9BPQ==' -H 'Connection: keep-alive' -H 'Content-Type: text/plain' --data-binary $'As a constituent, consumer, and tech user, I am deeply concerned about the provisions that are being written into the Trans-Pacific Partnership (TPP) and other trade agreements being negotiated by the Office of the United States Trade Representative. I oppose \u201ctrade\u201d policies that are developed without proper oversight or input from the public. The shear fact that wikileaks was the source to provide the full text of the bill should indicate that TPP outlines laws which are NOT in the best interests of the general public, since the laws had to be hidden from the public. TPP contains clauses which are unacceptable. These clauses will extend pharmaceutical drug patents, restrict internet freedoms, and create a legal framework for companies to sue nations over potential profit loss.f user created content which TPP seeks to destroy. For more information and arguments which are presented better then mine check out www.citizens.org and www.eff.org' --compressed
});
*/