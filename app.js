
//var credentials =
//      {
//        "url": "https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false",
//        "username": "f14b9d0b-3ced-45c7-98c3-99ed0ec9e96f",
//        "password": "4ibDVHnNjoUW"
//      }


var request = $.ajax({
  type: "POST",
  url: "https://gateway.watsonplatform.net/personality-insights/api/v2/profile?header=false",
  username:"f14b9d0b-3ced-45c7-98c3-99ed0ec9e96f",
  password:"4ibDVHnNjoUW",

  headers:{
    "Accept":"application/json",
    "Content-Type":"text/plain",
    "Accept-Language":"en",
    "Content-Language":"en",
    //"Origin": "chrome-extension://hnpoidiplkboebhfnmfhelmcbfdlomnn"

    //"Authorization":"Basic ZjE0YjlkMGItM2NlZC00NWM3LTk4YzMtOTllZDBlYzllOTZmOjRpYkRWSG5Oam9VVw=="
  },
  data:"xtending pharmaceutical patents beyond the current 20 years will prevent generic drug production forcing patients to pay more for the same medication. This disincentives investment in research and development of new and better drugs, and at a time when drug companies already spend 1.5-2 times more on marketing, then on R&D, it is foolish to further desincentivize the advancement of life saving drugs. We need more effective drugs not more expensive ones. These high costs will also preven",
  //success: success,
  dataType: "json"
});