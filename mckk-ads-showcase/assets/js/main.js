/* Progressive enhancements. No content mutations or remote requests. */
(() => {
  "use strict";
  const text = window.mckkAds || {};
  const nav = document.getElementById("site-navigation");
  const toggle = document.querySelector(".menu-toggle");
  const backdrop = document.querySelector(".navigation-backdrop");
  const mobile = window.matchMedia("(max-width: 959px)");
  let submenuCounter = 0;
  if (nav && toggle) {
    const setExpanded = (item, expanded) => {
      item.classList.toggle("is-open", expanded);
      const button = item.querySelector(":scope > .submenu-toggle");
      if (button) button.setAttribute("aria-expanded", String(expanded));
    };
    nav.querySelectorAll("li").forEach((item) => {
      const submenu = item.querySelector(":scope > ul");
      const link = item.querySelector(":scope > a");
      if (!submenu || !link) return;
      const button = document.createElement("button");
      button.type = "button";
      button.className = "submenu-toggle";
      submenu.id = `mckk-submenu-${++submenuCounter}`;
      button.setAttribute("aria-controls", submenu.id);
      button.setAttribute("aria-expanded", "false");
      button.setAttribute(
        "aria-label",
        `${text.expand || "Toggle submenu for"} ${link.textContent.trim()}`,
      );
      link.after(button);
      button.addEventListener("click", () => {
        const open = button.getAttribute("aria-expanded") !== "true";
        Array.from(item.parentElement.children).forEach((sibling) => {
          if (sibling !== item) setExpanded(sibling, false);
        });
        setExpanded(item, open);
      });
      item.addEventListener("pointerenter", (event) => {
        if (!mobile.matches && event.pointerType === "mouse")
          setExpanded(item, true);
      });
      item.addEventListener("pointerleave", () => {
        if (!mobile.matches && !item.contains(document.activeElement))
          setExpanded(item, false);
      });
      item.addEventListener("focusout", () => {
        setTimeout(() => {
          if (!item.contains(document.activeElement)) setExpanded(item, false);
        }, 0);
      });
      item.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && item.classList.contains("is-open")) {
          event.preventDefault();
          event.stopPropagation();
          setExpanded(item, false);
          button.focus();
        }
      });
    });
    const closeDrawer = (restore = false) => {
      toggle.setAttribute("aria-expanded", "false");
      nav.classList.remove("is-drawer-open");
      nav.inert = mobile.matches;
      document.body.classList.remove("drawer-open");
      if (backdrop) backdrop.hidden = true;
      if (restore) toggle.focus();
    };
    toggle.addEventListener("click", () => {
      if (toggle.getAttribute("aria-expanded") === "true") {
        closeDrawer(true);
        return;
      }
      toggle.setAttribute("aria-expanded", "true");
      nav.classList.add("is-drawer-open");
      nav.inert = false;
      document.body.classList.add("drawer-open");
      if (backdrop) backdrop.hidden = false;
      nav.querySelector("a")?.focus();
    });
    backdrop?.addEventListener("click", () => closeDrawer(true));
    document.addEventListener("keydown", (event) => {
      if (!mobile.matches || toggle.getAttribute("aria-expanded") !== "true")
        return;
      if (event.key === "Escape") {
        event.preventDefault();
        closeDrawer(true);
      }
      if (event.key === "Tab") {
        const focusable = [toggle, ...nav.querySelectorAll("a, button")].filter(
          (el) => el.getClientRects().length && !el.closest("[inert]"),
        );
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
          event.preventDefault();
          last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
          event.preventDefault();
          first.focus();
        }
      }
    });
    document.addEventListener("click", (event) => {
      if (!nav.contains(event.target) && !toggle.contains(event.target)) {
        nav
          .querySelectorAll(".is-open")
          .forEach((item) => setExpanded(item, false));
      }
    });
    mobile.addEventListener("change", () => closeDrawer());
    // Apply collapsed styles only after the controls are ready. No-JS menus stay visible.
    document.documentElement.classList.add("has-js");
    document.documentElement.classList.remove("mckk-pending");
    closeDrawer();
  }

  const contentAreas = document.querySelectorAll(".entry-content");
  // Existing external embeds keep their original URLs. Add an adjacent fallback only
  // when the source is safe and the editor hasn't already supplied that exact link.
  contentAreas.forEach((area) => {
    area.querySelectorAll("iframe[src]").forEach((frame) => {
      let url;
      try {
        url = new URL(frame.getAttribute("src"), document.baseURI);
      } catch {
        return;
      }
      if (!["https:", "http:"].includes(url.protocol)) return;
      if (
        Array.from(area.querySelectorAll("a[href]")).some(
          (a) => a.href === url.href,
        )
      )
        return;
      const p = document.createElement("p");
      const a = document.createElement("a");
      p.className = "embed-fallback";
      a.href = url.href;
      a.textContent = `${text.external || "Open embedded resource"} — ${frame.title || url.hostname}`;
      p.append(a);
      const wrapper = frame.closest(".wp-block-embed") || frame;
      wrapper.after(p);
    });
  });

  if (!text.lightbox || !("HTMLDialogElement" in window)) return;
  let dialog;
  let previousFocus;
  const openLightbox = (anchor, image) => {
    if (!dialog) {
      dialog = document.createElement("dialog");
      dialog.className = "image-lightbox";
      dialog.setAttribute("aria-label", text.enlarge || "Enlarge image");
      const inner = document.createElement("div");
      inner.className = "lightbox-inner";
      const close = document.createElement("button");
      close.className = "lightbox-close";
      close.type = "button";
      close.textContent = text.close || "Close image";
      const enlarged = document.createElement("img");
      const caption = document.createElement("p");
      caption.className = "lightbox-caption";
      caption.id = "mckk-lightbox-caption";
      const source = document.createElement("a");
      source.className = "lightbox-source";
      inner.append(close, enlarged, caption, source);
      dialog.append(inner);
      document.body.append(dialog);
      close.addEventListener("click", () => dialog.close());
      dialog.addEventListener("click", (event) => {
        if (event.target === dialog) dialog.close();
      });
      dialog.addEventListener("close", () => previousFocus?.focus());
      enlarged.addEventListener("error", () => {
        enlarged.hidden = true;
      });
    }
    previousFocus = document.activeElement;
    const enlarged = dialog.querySelector("img");
    enlarged.hidden = false;
    enlarged.src = anchor.href;
    enlarged.alt = image.alt;
    const captionText =
      anchor
        .closest("figure, .gallery-item, .wp-caption")
        ?.querySelector("figcaption, .gallery-caption, .wp-caption-text")
        ?.textContent.trim() || image.alt;
    const caption = dialog.querySelector(".lightbox-caption");
    caption.textContent = captionText;
    caption.hidden = !captionText;
    if (captionText) dialog.setAttribute("aria-describedby", caption.id);
    else dialog.removeAttribute("aria-describedby");
    const source = dialog.querySelector(".lightbox-source");
    source.href = anchor.href;
    source.textContent = text.original || "Open original image";
    dialog.showModal();
  };
  contentAreas.forEach((area) => {
    area.querySelectorAll("a[href]").forEach((anchor) => {
      const image = anchor.querySelector("img");
      if (
        !image ||
        anchor.querySelectorAll("img").length !== 1 ||
        anchor.hasAttribute("download") ||
        anchor.hasAttribute("target") ||
        anchor.closest(
          "[data-no-lightbox], .wp-lightbox-container, [data-wp-interactive], .wp-block-file",
        ) ||
        anchor.matches('[data-rel], [rel*="lightbox"], [data-fancybox]')
      )
        return;
      let url;
      try {
        url = new URL(anchor.href, document.baseURI);
      } catch {
        return;
      }
      if (
        url.origin !== location.origin ||
        !/\.(avif|gif|jpe?g|png|webp)$/i.test(url.pathname)
      )
        return;
      // Keep the author's anchor and its behavior. A separate button offers enlargement.
      const button = document.createElement("button");
      button.type = "button";
      button.className = "lightbox-trigger";
      button.textContent = text.enlarge || "Enlarge image";
      if (image.alt)
        button.setAttribute(
          "aria-label",
          `${text.enlarge || "Enlarge image"}: ${image.alt}`,
        );
      anchor.after(button);
      button.addEventListener("click", () => openLightbox(anchor, image));
    });
  });
})();
