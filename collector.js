function generateUniqueId() {
    return Math.random().toString(36).substring(2, 15);  
}
  
  let sessionId = generateUniqueId();
  const pageEntryTime = Date.now();
  
  async function postJSON(path, payload) {
    try {
      const res = await fetch(path, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
        keepalive: true 
      });
      return { ok: res.ok, status: res.status };
    } catch (e) {
      return { ok: false, status: 0, error: e };
    }
  }
  
  function getStaticInfo() {
    const staticData = {
      sessionId,
      timestamp: Date.now(),
      userAgent: navigator.userAgent || "",
      language: navigator.language || "",
      cookiesEnabled: navigator.cookieEnabled,
      javascriptEnabled: true,
      screenWidth: screen.width,
      screenHeight: screen.height,
      windowWidth: window.innerWidth,
      windowHeight: window.innerHeight,
      connectionType: navigator.connection ? navigator.connection.effectiveType : "unknown",
      imagesEnabled: true,
    };
  
    const div = document.createElement("div");
    div.style.display = "none";
    document.body.appendChild(div);
    staticData.cssEnabled = getComputedStyle(div).display === "none";
    div.remove();
  
    return staticData;
  }
  
  function getPerformanceData() {
    if (!window.performance || !performance.timing) return null;
  
    const t = performance.timing;
    const start = t.navigationStart;
    const end = t.loadEventEnd || Date.now();
    return {
      sessionId,
      timing: t,
      pageLoadStart: start,
      pageLoadEnd: end,
      totalLoadTime: end - start
    };
  }
  
  const activityData = {
    sessionId,
    errors: [],
    mouseMovements: [],
    clicks: [],
    scrolls: [],
    keyEvents: [],
    idlePeriods: []
  };
  
  let lastActivity = Date.now();
  let idleStart = null;
  
  function checkIdle() {
    const now = Date.now();
    if (now - lastActivity >= 2000) {
      idleStart = idleStart || lastActivity;
  	console.log("idle");
    } else if (idleStart) {
      activityData.idlePeriods.push({
        start: idleStart,
        duration: now - idleStart
      });
      idleStart = null;
    }
  }
 setInterval(checkIdle, 2000);  
  window.onerror = function(message, source, lineno, colno, error) {
    activityData.errors.push({ message, source, lineno, colno, error, timestamp: Date.now() });
  };
  
let lastMouseMove = 0;  
window.addEventListener("mousemove", e => {
  const now = Date.now();

  if (now - lastMouseMove >= 1000) {  // only once per second
    activityData.mouseMovements.push({
      x: e.clientX,
      y: e.clientY,
      timestamp: now
    });

    lastActivity = now;
    checkIdle();

    console.log("mousemove captured");
    lastMouseMove = now;
  }
}, { passive: true });

  window.addEventListener("click", e => {
    activityData.clicks.push({ x: e.clientX, y: e.clientY, button: e.button, timestamp: Date.now() });
    lastActivity = Date.now();
    checkIdle();
    console.log("click");
  }, { passive: true });
  
  window.addEventListener("scroll", () => {
    activityData.scrolls.push({ scrollX: window.scrollX, scrollY: window.scrollY, timestamp: Date.now() });
    lastActivity = Date.now();
    checkIdle();
    console.log("scroll");
  }, { passive: true });
  
  function handleKeyEvent(e, type) {
    const event = {
      type,
      key: e.key,
      code: e.code,
      altKey: e.altKey,
      ctrlKey: e.ctrlKey,
      metaKey: e.metaKey,
      shiftKey: e.shiftKey,
      timestamp: Date.now()
    };
    activityData.keyEvents.push(event);
  
    lastActivity = Date.now();
    checkIdle();
  
    console.log("key");
  }
  
  window.addEventListener("keydown", e => handleKeyEvent(e, "keydown"), { passive: true });
  window.addEventListener("keyup", e => handleKeyEvent(e, "keyup"), { passive: true });
  
  async function sendFinalReport() {
    const pageExitTime = Date.now();
    const totalTimeOnPage = pageExitTime - pageEntryTime;
  
    const finalData = {
      sessionId,
      pageEntryTime,
      pageExitTime,
      totalTimeOnPage,
      staticData: getStaticInfo(),
      performanceData: getPerformanceData(),
      activityData
    };
  
    await postJSON("/json/posts", finalData);
  }
  
  async function init() {
    const staticInfo = getStaticInfo();
    await postJSON("/json/posts", staticInfo);
    console.log("sessionId:", sessionId);
  }
  
  window.addEventListener("load", init);
  window.addEventListener("beforeunload", sendFinalReport);
  
  

