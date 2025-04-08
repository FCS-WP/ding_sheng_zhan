import React from "react";
import ReactDOM from "react-dom/client";
import Dashboard from "./Components/Pages/Dashboad";
import Settings from "./Components/Pages/Settings";

// Zippy Dashboard

document.addEventListener("DOMContentLoaded", function () {
  const zippyMain = document.getElementById("zippy-main");

  if (typeof zippyMain != "undefined" && zippyMain != null) {
    const root = ReactDOM.createRoot(zippyMain);
    root.render(<Dashboard />);
  }
});

// Zippy Settings

document.addEventListener("DOMContentLoaded", function () {
  const zippySetting = document.getElementById("zippy-settings");

  if (typeof zippySetting != "undefined" && zippySetting != null) {
    const root = ReactDOM.createRoot(zippySetting);
    root.render(<Settings />);
  }
});
