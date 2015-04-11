var credentials = {
  "personality_insights": [
    {
      "name": "Personality Insights-rh",
      "label": "personality_insights",
      "plan": "IBM Watson Personality Insights Monthly Plan",
      "credentials": {
        "url": "https://gateway.watsonplatform.net/personality-insights/api",
        "username": "f14b9d0b-3ced-45c7-98c3-99ed0ec9e96f",
        "password": "4ibDVHnNjoUW"
      }
    }
  ]
}
//full contact
var personalityInsights = new watson.personality_insights(credentials);
document.write(Date());

