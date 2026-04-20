    /* ===================================
       DESIGN SYSTEM — APPLE STYLE
    =================================== */
    :root {
      --gold-50: #fdf8ef;
      --gold-100: #f8edcf;
      --gold-200: #f0d99c;
      --gold-300: #e6c266;
      --gold-400: #dcab3a;
      --gold-500: #b8901f;
      --gold-600: #9a7519;
      --gold-700: #7a5c14;
      --gold-800: #5e460f;
      --gold-900: #42300b;

      --neutral-900: #0a0a0a;
      --neutral-800: #1c1c1e;
      --neutral-700: #2c2c2e;
      --neutral-600: #3a3a3c;
      --neutral-500: #48484a;
      --neutral-400: #636366;
      --neutral-300: #aeaeb2;
      --neutral-200: #d1d1d6;
      --neutral-100: #f2f2f7;
      --neutral-50: #fbfbfd;
      --white: #ffffff;

      --font-display: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      --radius-sm: 12px;
      --radius-md: 20px;
      --radius-lg: 28px;
      --radius-xl: 40px;
      --radius-full: 9999px;
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, .08);
      --shadow-md: 0 8px 32px rgba(0, 0, 0, .12);
      --shadow-lg: 0 20px 60px rgba(0, 0, 0, .18);
      --shadow-gold: 0 8px 40px rgba(184, 144, 31, .25);

      --transition-fast: 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      --transition-med: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      --transition-slow: 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
      font-size: 16px;
      -webkit-text-size-adjust: 100%;
    }

    body {
      font-family: var(--font-display);
      background: var(--neutral-900);
      color: var(--white);
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* ===================================
       01. NAVBAR
    =================================== */
    #navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      padding: 16px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all var(--transition-med);
    }

    #navbar.scrolled {
      background: rgba(10, 10, 10, 0.88);
      backdrop-filter: saturate(180%) blur(20px);
      -webkit-backdrop-filter: saturate(180%) blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .nav-logo img {
      height: 36px;
      width: auto;
      max-width: 100%;
      object-fit: contain;
    }

    .nav-logo-text {
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.08em;
      color: var(--white);
      text-transform: uppercase;
      line-height: 1.2;
    }

    .nav-logo-text span {
      display: block;
      font-weight: 400;
      font-size: 10px;
      letter-spacing: 0.15em;
      color: var(--gold-300);
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }

    .nav-links a {
      font-size: 14px;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.75);
      text-decoration: none;
      transition: color var(--transition-fast);
    }

    .nav-links a:hover {
      color: var(--white);
    }

    .nav-cta {
      background: var(--gold-500);
      color: var(--white) !important;
      padding: 8px 20px;
      border-radius: var(--radius-full);
      font-weight: 600 !important;
      font-size: 13px !important;
      transition: all var(--transition-fast) !important;
    }

    .nav-cta:hover {
      background: var(--gold-400) !important;
      transform: scale(1.03);
      box-shadow: var(--shadow-gold);
    }

    .nav-burger {
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      padding: 8px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      transition: all var(--transition-med);
      width: 40px;
      height: 40px;
      flex-shrink: 0;
    }

    .nav-burger:hover {
      background: rgba(184, 144, 31, 0.15);
      border-color: rgba(184, 144, 31, 0.3);
    }

    .nav-burger svg rect {
      transform-origin: center;
      transition: all 0.3s ease;
    }

    .nav-burger.open svg rect:nth-child(1) {
      transform: translateY(4.1px) rotate(45deg);
    }

    .nav-burger.open svg rect:nth-child(2) {
      opacity: 0;
      transform: scale(0);
    }

    .nav-burger.open svg rect:nth-child(3) {
      transform: translateY(-4.1px) rotate(-45deg);
    }

    .nav-burger svg {
      display: block;
      transition: all var(--transition-med);
    }

    /* Mobile nav */
    .mobile-nav {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(10, 10, 10, 0.96);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      z-index: 999;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 32px;
    }

    .mobile-nav.open {
      display: flex;
    }

    .mobile-nav a {
      font-size: 28px;
      font-weight: 700;
      color: var(--white);
      text-decoration: none;
      letter-spacing: -0.02em;
      transition: color var(--transition-fast);
    }

    .mobile-nav a:hover {
      color: var(--gold-300);
    }

    .mobile-nav-close {
      position: absolute;
      top: 24px;
      right: 24px;
      font-size: 32px;
      color: var(--white);
      cursor: pointer;
      line-height: 1;
      background: none;
      border: none;
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
      }

      .nav-burger {
        display: flex;
      }
    }

    /* ===================================
       02. HERO SECTION
    =================================== */
    #hero {
      min-height: 100svh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 100px 24px 80px;
      position: relative;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(184, 144, 31, 0.15) 0%, transparent 60%),
        radial-gradient(ellipse 60% 80% at 20% 80%, rgba(184, 144, 31, 0.08) 0%, transparent 50%),
        var(--neutral-900);
    }

    .hero-grid {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px);
      background-size: 60px 60px;
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 80%);
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(184, 144, 31, 0.12);
      border: 1px solid rgba(184, 144, 31, 0.3);
      border-radius: var(--radius-full);
      padding: 6px 16px;
      font-size: 12px;
      font-weight: 600;
      color: var(--gold-300);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 32px;
      position: relative;
    }

    .hero-badge::before {
      content: '';
      width: 6px;
      height: 6px;
      background: var(--gold-400);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
        transform: scale(1);
      }

      50% {
        opacity: 0.5;
        transform: scale(1.4);
      }
    }

    .hero-eyebrow {
      font-size: clamp(11px, 3vw, 13px);
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--gold-400);
      margin-bottom: 20px;
    }

    .hero-title {
      font-size: clamp(36px, 10vw, 96px);
      font-weight: 800;
      line-height: 1.02;
      letter-spacing: -0.04em;
      color: var(--white);
      margin-bottom: 24px;
      position: relative;
    }

    .hero-title .gradient-text {
      background: linear-gradient(135deg, var(--gold-200), var(--gold-500), var(--gold-300));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-sub {
      font-size: clamp(16px, 3.5vw, 22px);
      font-weight: 400;
      color: rgba(255, 255, 255, 0.55);
      max-width: 560px;
      margin: 0 auto 48px;
      line-height: 1.5;
    }

    .hero-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--gold-400), var(--gold-600));
      color: var(--white);
      padding: 16px 32px;
      border-radius: var(--radius-full);
      font-size: 16px;
      font-weight: 700;
      text-decoration: none;
      transition: all var(--transition-med);
      box-shadow: 0 8px 32px rgba(184, 144, 31, 0.4);
      border: none;
      cursor: pointer;
    }

    .btn-primary:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 16px 48px rgba(184, 144, 31, 0.5);
    }

    .btn-secondary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.08);
      color: var(--white);
      padding: 16px 32px;
      border-radius: var(--radius-full);
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
      transition: all var(--transition-med);
      border: 1px solid rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.14);
      transform: translateY(-2px);
    }

    .hero-scroll-indicator {
      position: absolute;
      bottom: 32px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, 0.3);
      font-size: 11px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    .scroll-arrow {
      width: 24px;
      height: 24px;
      border-right: 2px solid rgba(184, 144, 31, .5);
      border-bottom: 2px solid rgba(184, 144, 31, .5);
      transform: rotate(45deg);
      animation: scrollBounce 1.5s ease-in-out infinite;
    }

    @keyframes scrollBounce {

      0%,
      100% {
        transform: rotate(45deg) translateY(0);
      }

      50% {
        transform: rotate(45deg) translateY(6px);
      }
    }

    /* Floating particles */
    .particles {
      position: absolute;
      inset: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(220, 171, 58, 0.6) 0%, transparent 70%);
      animation: float linear infinite;
    }

    @keyframes float {
      0% {
        transform: translateY(100vh) scale(0);
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      90% {
        opacity: 1;
      }

      100% {
        transform: translateY(-100px) scale(1);
        opacity: 0;
      }
    }

    /* ===================================
       03. STATS MARQUEE
    =================================== */
    #marquee-section {
      padding: 20px 0;
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.08), rgba(184, 144, 31, 0.03));
      border-top: 1px solid rgba(184, 144, 31, 0.15);
      border-bottom: 1px solid rgba(184, 144, 31, 0.15);
      overflow: hidden;
    }

    .marquee-track {
      display: flex;
      gap: 0;
      animation: marqueeScroll 30s linear infinite;
      width: max-content;
    }

    @keyframes marqueeScroll {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }

    .marquee-item {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 0 40px;
      white-space: nowrap;
      color: rgba(255, 255, 255, 0.7);
      font-size: 13px;
      font-weight: 500;
      letter-spacing: 0.05em;
    }

    .marquee-dot {
      width: 4px;
      height: 4px;
      background: var(--gold-400);
      border-radius: 50%;
    }

    .marquee-icon {
      font-size: 16px;
      color: var(--gold-400);
    }

    #products,
    #projects {
      padding: 120px 24px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-label {
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--gold-400);
      margin-bottom: 16px;
    }

    .section-title {
      font-size: clamp(28px, 6vw, 56px);
      font-weight: 800;
      letter-spacing: -0.03em;
      line-height: 1.08;
      color: var(--white);
      margin-bottom: 16px;
    }

    .section-sub {
      font-size: clamp(15px, 2.5vw, 18px);
      color: rgba(255, 255, 255, 0.5);
      max-width: 480px;
      line-height: 1.6;
      margin-bottom: 64px;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    /* Fix: ensure all cards have same min-height so arrow doesn't overlap content */
    .product-card {
      min-height: 260px;
    }

    .product-card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      padding: 40px 32px;
      position: relative;
      overflow: hidden;
      cursor: pointer;
      transition: all var(--transition-med);
      transform: translateY(0);
    }

    .product-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.08) 0%, transparent 60%);
      opacity: 0;
      transition: opacity var(--transition-med);
    }

    .product-card:hover {
      border-color: rgba(184, 144, 31, 0.35);
      transform: translateY(-8px);
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(184, 144, 31, 0.2);
    }

    .product-card:hover::before {
      opacity: 1;
    }

    .product-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.2), rgba(184, 144, 31, 0.05));
      border: 1px solid rgba(184, 144, 31, 0.25);
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      margin-bottom: 24px;
      transition: all var(--transition-med);
    }

    .product-card:hover .product-icon {
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.3), rgba(184, 144, 31, 0.1));
      transform: scale(1.1);
    }

    .product-name {
      font-size: 22px;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--white);
      margin-bottom: 10px;
    }

    .product-desc {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.5);
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .product-tag {
      display: inline-flex;
      padding: 4px 12px;
      background: rgba(184, 144, 31, 0.12);
      border: 1px solid rgba(184, 144, 31, 0.2);
      border-radius: var(--radius-full);
      font-size: 11px;
      font-weight: 600;
      color: var(--gold-300);
      letter-spacing: 0.08em;
    }

    .product-arrow {
      position: absolute;
      bottom: 32px;
      right: 32px;
      width: 36px;
      height: 36px;
      background: rgba(184, 144, 31, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      transition: all var(--transition-med);
      color: var(--gold-300);
    }

    .product-card:hover .product-arrow {
      background: var(--gold-500);
      color: var(--white);
      transform: translate(4px, -4px);
    }

    /* ===================================
       05. SHOWCASE / FULLBLEED
    =================================== */
    #showcase {
      padding: 80px 0;
      overflow: hidden;
    }

    .showcase-inner {
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.06) 0%, rgba(10, 10, 10, 1) 100%);
      border-top: 1px solid rgba(184, 144, 31, .1);
      border-bottom: 1px solid rgba(184, 144, 31, .1);
      padding: 100px 24px;
    }

    .showcase-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }

    .showcase-visual {
      position: relative;
    }

    .showcase-card-main {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-xl);
      padding: 48px;
      aspect-ratio: 4/3;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      /* overflow removed so floating cards are fully visible */
    }

    .showcase-card-main::before {
      content: '';
      position: absolute;
      top: -40%;
      left: -40%;
      width: 180%;
      height: 180%;
      background: conic-gradient(from 0deg, transparent, rgba(184, 144, 31, 0.1), transparent 60%);
      animation: rotateConic 8s linear infinite;
    }

    @keyframes rotateConic {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .showcase-logo-display {
      font-size: 100px;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .showcase-floating-card {
      position: absolute;
      background: rgba(20, 20, 20, 0.9);
      border: 1px solid rgba(184, 144, 31, 0.25);
      border-radius: var(--radius-md);
      padding: 16px 20px;
      backdrop-filter: blur(20px);
    }

    .showcase-floating-card.top-right {
      top: -20px;
      right: -20px;
    }

    .showcase-floating-card.bottom-left {
      bottom: -20px;
      left: -20px;
    }

    .floating-card-label {
      font-size: 10px;
      font-weight: 600;
      color: var(--gold-400);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .floating-card-value {
      font-size: 20px;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: var(--white);
    }

    .showcase-content {}

    .showcase-features {
      list-style: none;
      margin-top: 40px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .showcase-feature {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }

    .feature-icon {
      width: 40px;
      height: 40px;
      min-width: 40px;
      background: rgba(184, 144, 31, 0.12);
      border: 1px solid rgba(184, 144, 31, 0.2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .feature-text h4 {
      font-size: 15px;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 4px;
    }

    .feature-text p {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.45);
      line-height: 1.5;
    }

    @media (max-width: 768px) {
      .showcase-container {
        grid-template-columns: 1fr;
        gap: 48px;
      }

      .showcase-floating-card.top-right {
        top: -10px;
        right: -10px;
      }

      .showcase-floating-card.bottom-left {
        bottom: -10px;
        left: -10px;
      }
    }

    /* ===================================
       06. STATS COUNTER
    =================================== */
    #stats {
      padding: 100px 24px;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: var(--radius-xl);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.08);
      margin-top: 64px;
    }

    .stat-item {
      background: var(--neutral-900);
      padding: 48px 32px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      position: relative;
      transition: background var(--transition-med);
    }

    .stat-number {
      font-size: clamp(40px, 7vw, 72px);
      font-weight: 800;
      letter-spacing: -0.04em;
      background: linear-gradient(135deg, var(--white), var(--gold-300));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1;
    }

    .stat-label {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.45);
      font-weight: 500;
      letter-spacing: 0.02em;
    }

    .stat-suffix {
      font-size: 32px;
      font-weight: 800;
      background: linear-gradient(135deg, var(--gold-300), var(--gold-500));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ===================================
       07. HOW IT WORKS (PROCESS)
    =================================== */
    #process {
      padding: 120px 24px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .process-steps {
      margin-top: 64px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 24px;
      position: relative;
    }

    .process-step {
      position: relative;
      padding: 40px 32px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: var(--radius-lg);
      overflow: hidden;
      transition: all var(--transition-med);
    }

    .step-number {
      font-size: 72px;
      font-weight: 900;
      letter-spacing: -0.05em;
      line-height: 1;
      color: rgba(255, 255, 255, 0.04);
      position: absolute;
      top: 16px;
      right: 20px;
      font-variant-numeric: tabular-nums;
    }

    .step-icon {
      font-size: 32px;
      margin-bottom: 20px;
    }

    .step-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 10px;
      letter-spacing: -0.01em;
    }

    .step-desc {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.45);
      line-height: 1.6;
    }

    /* ===================================
       08. TESTIMONIALS
    =================================== */
    #testimonials {
      padding: 120px 24px;
      overflow: hidden;
    }

    .testimonials-wrapper {
      max-width: 1200px;
      margin: 0 auto;
    }

    .testimonials-slider {
      margin-top: 64px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }

    .testimonial-card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      padding: 36px 32px;
      transition: all var(--transition-med);
      position: relative;
    }

    .testimonial-stars {
      display: flex;
      gap: 4px;
      margin-bottom: 20px;
      color: var(--gold-400);
      font-size: 16px;
    }

    .testimonial-text {
      font-size: 15px;
      color: rgba(255, 255, 255, 0.7);
      line-height: 1.7;
      margin-bottom: 28px;
      font-style: italic;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .author-avatar {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, var(--gold-400), var(--gold-600));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 700;
      color: var(--white);
      flex-shrink: 0;
    }

    .author-info h5 {
      font-size: 14px;
      font-weight: 700;
      color: var(--white);
    }

    .author-info p {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.4);
    }

    .testimonial-quote {
      position: absolute;
      top: 24px;
      right: 28px;
      font-size: 48px;
      color: rgba(184, 144, 31, 0.12);
      font-family: Georgia, serif;
      line-height: 1;
    }

    /* ---- GRID CARDS ---- */
    .gallery-category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
      margin-top: 40px;
    }

    .gallery-card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      overflow: hidden;
      cursor: pointer;
      transition: all var(--transition-med);
      display: flex;
      flex-direction: column;
    }

    .gallery-card:hover {
      border-color: rgba(184, 144, 31, 0.3);
      transform: translateY(-6px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    }

    .gallery-card-visual {
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 56px;
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
    }

    .gallery-card-body {
      padding: 24px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .gallery-card-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--white);
    }

    .gallery-card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: auto;
      padding-top: 12px;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .gallery-card-loc {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.35);
    }

    .gallery-card-tag {
      display: inline-flex;
      padding: 4px 12px;
      background: rgba(184, 144, 31, 0.1);
      border: 1px solid rgba(184, 144, 31, 0.18);
      border-radius: var(--radius-full);
      font-size: 11px;
      font-weight: 600;
      color: var(--gold-300);
    }

    /* ===================================
       10. CTA / CONTACT SECTION
    =================================== */
    #contact {
      padding: 80px 24px 120px;
    }

    .cta-container {
      max-width: 900px;
      margin: 0 auto;
      background: linear-gradient(135deg, rgba(184, 144, 31, 0.12), rgba(184, 144, 31, 0.04));
      border: 1px solid rgba(184, 144, 31, 0.2);
      border-radius: var(--radius-xl);
      padding: 80px 48px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .cta-title {
      font-size: clamp(28px, 6vw, 52px);
      font-weight: 800;
      letter-spacing: -0.03em;
      line-height: 1.08;
      color: var(--white);
      margin-bottom: 16px;
    }

    .cta-sub {
      font-size: clamp(14px, 2.5vw, 18px);
      color: rgba(255, 255, 255, 0.5);
      margin-bottom: 48px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
    }

    .btn-whatsapp {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #25D366;
      color: var(--white);
      padding: 16px 32px;
      border-radius: var(--radius-full);
      font-size: 16px;
      font-weight: 700;
      text-decoration: none;
      transition: all var(--transition-med);
      box-shadow: 0 8px 32px rgba(37, 211, 102, 0.35);
    }

    .cta-info-cards {
      margin-top: 64px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
    }

    .info-card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-md);
      padding: 24px 20px;
      text-align: center;
    }

    .info-card-icon {
      font-size: 24px;
      margin-bottom: 12px;
    }

    .info-card-title {
      font-size: 12px;
      font-weight: 600;
      color: var(--gold-400);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .info-card-value {
      font-size: 14px;
      font-weight: 600;
      color: var(--white);
      line-height: 1.4;
    }

    /* ===================================
       11. FOOTER
    =================================== */
    footer {
      padding: 48px 24px 32px;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-inner {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
    }

    .footer-brand h3 {
      font-size: 16px;
      font-weight: 800;
      letter-spacing: 0.05em;
      color: var(--white);
    }

    .footer-brand p {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.35);
      margin-top: 4px;
    }

    .footer-links {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      list-style: none;
    }

    .footer-links a {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.4);
      text-decoration: none;
      transition: color var(--transition-fast);
    }

    .footer-links a:hover {
      color: var(--gold-300);
    }

    .footer-copy {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.2);
      text-align: center;
      margin-top: 32px;
    }

    /* ===================================
       12. PROJECT & CATEGORY GRIDS
    =================================== */
    .projects-grid, .category-grid, .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
      margin-top: 40px;
    }

    .project-card, .category-card {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: var(--radius-lg);
      overflow: hidden;
      transition: all var(--transition-med);
      cursor: pointer;
    }

    .project-card:hover, .category-card:hover {
      border-color: rgba(184, 144, 31, 0.3);
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .project-img-wrapper, .category-image {
      height: 220px;
      overflow: hidden;
      position: relative;
    }

    .project-img-wrapper img, .category-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s ease;
    }

    .project-card:hover img, .category-card:hover img {
      transform: scale(1.1);
    }

    .project-info, .category-info {
        padding: 24px;
    }

    .project-category, .category-badge {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--gold-400);
        margin-bottom: 8px;
        display: block;
    }

    .project-title, .category-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 8px;
    }

    .project-location {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
    }

    /* ===================================
       13. PARTICLES
    =================================== */
    #particles {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 1;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(184, 144, 31, 0.4) 0%, transparent 70%);
      animation: float linear infinite;
    }

    @keyframes float {
      0% { transform: translateY(110vh) scale(0); opacity: 0; }
      10% { opacity: 0.8; }
      90% { opacity: 0.8; }
      100% { transform: translateY(-10vh) scale(1.5); opacity: 0; }
    }

    /* ===================================
       UTILITY / ANIMATION CLASSES
    =================================== */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
    }

    .reveal-left {
      opacity: 0;
      transform: translateX(-40px);
    }

    .reveal-right {
      opacity: 0;
      transform: translateX(40px);
    }

    @media (max-width: 768px) {
      #products, #projects, #stats, #process, #testimonials {
        padding: 80px 20px;
      }
      .gallery-category-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
      }
    }

    @media (max-width: 480px) {
      .gallery-category-grid {
        grid-template-columns: 1fr;
      }
      .stats-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    /* ===================================
       FLOATING WA BUTTON
    =================================== */
    #wa-float {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 998;
      width: 60px;
      height: 60px;
      background: #25D366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4);
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #wa-float:hover {
      transform: scale(1.12);
      box-shadow: 0 12px 48px rgba(37, 211, 102, 0.6);
    }

    @keyframes floatPulse {
      0%, 100% { box-shadow: 0 8px 32px rgba(37, 211, 102, 0.45), 0 0 0 0 rgba(37, 211, 102, 0.4); }
      50% { box-shadow: 0 8px 32px rgba(37, 211, 102, 0.45), 0 0 0 20px rgba(37, 211, 102, 0); }
    }
    
    #wa-float {
      animation: floatPulse 3s infinite;
    }
