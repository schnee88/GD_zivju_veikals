<!DOCTYPE html>
<html lang="lv">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Zivju Veikals</title>
     <style>
          /* === MAINĪGIE & PAMATA STILI === */
          :root {
               --primary: #2563eb;
               --primary-dark: #1d4ed8;
               --primary-light: #dbeafe;
               --secondary: #64748b;
               --success: #10b981;
               --success-dark: #059669;
               --warning: #f59e0b;
               --error: #ef4444;
               --error-dark: #dc2626;

               --dark: #1e293b;
               --gray-800: #1f2937;
               --gray-700: #374151;
               --gray-600: #4b5563;
               --gray-500: #6b7280;
               --gray-400: #9ca3af;
               --gray-300: #d1d5db;
               --gray-200: #e5e7eb;
               --gray-100: #f3f4f6;
               --gray-50: #f9fafb;
               --white: #ffffff;

               --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
               --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
               --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
               --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

               --radius-sm: 6px;
               --radius-md: 8px;
               --radius-lg: 12px;
               --radius-xl: 16px;

               --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
               --transition-fast: all 0.15s ease;
          }

          * {
               margin: 0;
               padding: 0;
               box-sizing: border-box;
          }

          body {
               font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
               margin: 0;
               padding: 0;
               line-height: 1.6;
               display: flex;
               flex-direction: column;
               min-height: 100vh;
               background: var(--gray-50);
               color: var(--gray-800);
               font-size: 14px;
          }

          .container {
               max-width: 1200px;
               margin: 0 auto;
               padding: 0 20px;
          }

          h1 {
               text-align: center;
               margin: 24px 0;
               color: var(--dark);
               font-weight: 700;
               font-size: 2rem;
          }

          /* === HOME PAGE STYLES === */
          /* Modern Hero Section */
          .modern-hero {
               background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
               color: white;
               padding: 100px 40px;
               border-radius: 24px;
               margin: 40px 0;
               position: relative;
               overflow: hidden;
               box-shadow: 0 20px 60px rgba(30, 58, 138, 0.3);
          }

          .modern-hero::before {
               content: '';
               position: absolute;
               top: -50%;
               right: -10%;
               width: 500px;
               height: 500px;
               background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
               border-radius: 50%;
               animation: float 15s ease-in-out infinite;
          }

          .modern-hero::after {
               content: '';
               position: absolute;
               bottom: -30%;
               left: -5%;
               width: 400px;
               height: 400px;
               background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
               border-radius: 50%;
               animation: float 20s ease-in-out infinite reverse;
          }

          @keyframes float {

               0%,
               100% {
                    transform: translate(0, 0) scale(1);
               }

               50% {
                    transform: translate(30px, 30px) scale(1.1);
               }
          }

          .hero-content {
               position: relative;
               z-index: 1;
               max-width: 800px;
               margin: 0 auto;
               text-align: center;
          }

          .hero-badge {
               display: inline-block;
               background: rgba(255, 255, 255, 0.2);
               padding: 8px 20px;
               border-radius: 50px;
               font-size: 0.9rem;
               font-weight: 600;
               margin-bottom: 20px;
               backdrop-filter: blur(10px);
               border: 1px solid rgba(255, 255, 255, 0.3);
          }

          .hero-title {
               font-size: 3.5rem;
               font-weight: 800;
               margin: 0 0 20px 0;
               line-height: 1.2;
               letter-spacing: -1px;
          }

          .hero-subtitle {
               font-size: 1.3rem;
               margin: 0 0 15px 0;
               opacity: 0.95;
               font-weight: 500;
          }

          .hero-features {
               display: flex;
               justify-content: center;
               gap: 30px;
               margin: 30px 0;
               flex-wrap: wrap;
          }

          .hero-feature {
               display: flex;
               align-items: center;
               gap: 10px;
               font-size: 1rem;
               font-weight: 500;
          }

          .hero-feature-icon {
               font-size: 1.5rem;
          }

          .hero-actions {
               display: flex;
               justify-content: center;
               gap: 15px;
               margin-top: 40px;
               flex-wrap: wrap;
          }

          .btn-hero-primary {
               background: white;
               color: #1e3a8a;
               padding: 16px 32px;
               border-radius: 12px;
               text-decoration: none;
               font-weight: 700;
               font-size: 1.05rem;
               transition: all 0.3s ease;
               box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
               display: inline-flex;
               align-items: center;
               gap: 10px;
          }

          .btn-hero-primary:hover {
               transform: translateY(-3px);
               box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
               background: #f8fafc;
          }

          .btn-hero-secondary {
               background: rgba(255, 255, 255, 0.15);
               color: white;
               padding: 16px 32px;
               border-radius: 12px;
               text-decoration: none;
               font-weight: 700;
               font-size: 1.05rem;
               transition: all 0.3s ease;
               backdrop-filter: blur(10px);
               border: 2px solid rgba(255, 255, 255, 0.3);
               display: inline-flex;
               align-items: center;
               gap: 10px;
          }

          .btn-hero-secondary:hover {
               background: rgba(255, 255, 255, 0.25);
               transform: translateY(-3px);
               border-color: rgba(255, 255, 255, 0.5);
          }

          /* Features Section */
          .features-section {
               margin: 60px 0;
          }

          .section-header {
               text-align: center;
               margin-bottom: 50px;
          }

          .section-title {
               font-size: 2.5rem;
               font-weight: 800;
               color: var(--dark);
               margin: 0 0 15px 0;
          }

          .section-subtitle {
               font-size: 1.1rem;
               color: var(--gray-600);
               max-width: 600px;
               margin: 0 auto;
          }

          .features-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
               gap: 30px;
               margin-top: 40px;
          }

          .feature-card {
               background: var(--white);
               padding: 35px 30px;
               border-radius: 20px;
               box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
               transition: var(--transition);
               border: 1px solid var(--gray-200);
               text-align: center;
          }

          .feature-card:hover {
               transform: translateY(-8px);
               box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
               border-color: var(--primary);
          }

          .feature-icon {
               font-size: 3rem;
               margin-bottom: 20px;
               display: block;
          }

          .feature-title {
               font-size: 1.3rem;
               font-weight: 700;
               color: var(--dark);
               margin: 0 0 12px 0;
          }

          .feature-description {
               color: var(--gray-600);
               line-height: 1.6;
               margin: 0;
          }

          /* How to Order Section */
          .how-to-order {
               background: linear-gradient(135deg, var(--gray-100) 0%, #e0f2fe 100%);
               padding: 60px 40px;
               border-radius: 24px;
               margin: 60px 0;
               border: 1px solid #bfdbfe;
          }

          .order-steps {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
               gap: 40px;
               margin-top: 40px;
          }

          .order-step {
               text-align: center;
               position: relative;
          }

          .step-number {
               display: inline-flex;
               align-items: center;
               justify-content: center;
               width: 60px;
               height: 60px;
               background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
               color: white;
               border-radius: 50%;
               font-size: 1.5rem;
               font-weight: 800;
               margin-bottom: 20px;
               box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
          }

          .step-title {
               font-size: 1.2rem;
               font-weight: 700;
               color: var(--dark);
               margin: 0 0 10px 0;
          }

          .step-description {
               color: var(--gray-600);
               line-height: 1.6;
               margin: 0;
          }

          /* Contact CTA */
          .contact-cta {
               background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
               color: white;
               padding: 50px 40px;
               border-radius: 24px;
               text-align: center;
               margin: 60px 0;
               box-shadow: 0 20px 60px rgba(16, 185, 129, 0.3);
          }

          .contact-cta h3 {
               font-size: 2rem;
               font-weight: 800;
               margin: 0 0 15px 0;
          }

          .contact-cta p {
               font-size: 1.1rem;
               margin: 10px 0;
               opacity: 0.95;
          }

          .phone-number {
               display: inline-block;
               background: rgba(255, 255, 255, 0.2);
               color: white;
               padding: 15px 35px;
               border-radius: 50px;
               font-size: 1.5rem;
               font-weight: 800;
               text-decoration: none;
               margin: 20px 0;
               backdrop-filter: blur(10px);
               border: 2px solid rgba(255, 255, 255, 0.3);
               transition: var(--transition);
          }

          .phone-number:hover {
               background: rgba(255, 255, 255, 0.3);
               transform: scale(1.05);
               border-color: rgba(255, 255, 255, 0.5);
          }

          .working-hours {
               font-size: 1rem;
               opacity: 0.9;
               margin-top: 15px;
          }

          /* === NAVIGATION STYLES === */
          nav {
               background: linear-gradient(135deg, var(--dark) 0%, var(--gray-800) 100%);
               color: var(--white);
               padding: 0;
               margin-bottom: 0;
               box-shadow: var(--shadow-lg);
               position: sticky;
               top: 0;
               z-index: 1000;
               backdrop-filter: blur(10px);
          }

          nav .container {
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 0 20px;
          }

          nav>.container>div {
               display: flex;
               align-items: center;
               gap: 8px;
          }

          nav a {
               color: var(--white);
               text-decoration: none;
               padding: 16px 12px;
               border-radius: var(--radius-sm);
               transition: var(--transition-fast);
               font-weight: 500;
               position: relative;
               opacity: 0.9;
          }

          nav a:hover {
               background: rgba(255, 255, 255, 0.1);
               opacity: 1;
               transform: translateY(-1px);
          }

          nav a::after {
               content: '';
               position: absolute;
               bottom: 0;
               left: 50%;
               width: 0;
               height: 2px;
               background: var(--primary);
               transition: var(--transition);
               transform: translateX(-50%);
          }

          nav a:hover::after {
               width: 80%;
          }

          nav form {
               margin: 0;
          }

          nav button[type="submit"] {
               background: var(--error);
               color: var(--white);
               padding: 8px 16px;
               border: none;
               border-radius: var(--radius-sm);
               cursor: pointer;
               transition: var(--transition);
               font-weight: 500;
          }

          nav button[type="submit"]:hover {
               background: var(--error-dark);
               transform: translateY(-1px);
          }

          .cart-badge {
               background: var(--error);
               color: var(--white);
               padding: 2px 8px;
               border-radius: 12px;
               font-size: 0.75rem;
               font-weight: 600;
               margin-left: 6px;
               animation: pulse 2s infinite;
          }

          @keyframes pulse {

               0%,
               100% {
                    transform: scale(1);
               }

               50% {
                    transform: scale(1.05);
               }
          }

          /* === ALERTS === */
          .alert {
               padding: 16px 20px;
               margin: 20px 0;
               border-radius: var(--radius-md);
               border: 1px solid transparent;
               font-weight: 500;
               box-shadow: var(--shadow-sm);
               animation: slideDown 0.3s ease-out;
          }

          @keyframes slideDown {
               from {
                    opacity: 0;
                    transform: translateY(-10px);
               }

               to {
                    opacity: 1;
                    transform: translateY(0);
               }
          }

          .alert-success {
               background: #f0fdf4;
               color: #166534;
               border-color: #bbf7d0;
               border-left: 4px solid var(--success);
          }

          .alert-error {
               background: #fef2f2;
               color: #991b1b;
               border-color: #fecaca;
               border-left: 4px solid var(--error);
          }

          /* === FORMAS - UZLABOTAS === */
          .form-group {
               margin-bottom: 20px;
          }

          .form-group label {
               display: block;
               margin-bottom: 8px;
               font-weight: 600;
               color: var(--gray-700);
               font-size: 0.9rem;
          }

          .form-group input,
          .form-group textarea,
          .form-group select {
               width: 100%;
               padding: 12px 16px;
               border: 2px solid var(--gray-300);
               border-radius: var(--radius-md);
               font-size: 1rem;
               transition: var(--transition);
               background: var(--white);
          }

          .form-group input:focus,
          .form-group textarea:focus,
          .form-group select:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 3px var(--primary-light);
               transform: translateY(-1px);
          }

          form input[type="file"] {
               border: none;
               padding: 12px 0;
               background: transparent;
          }

          /* === POGAS - MODERNAS === */
          button,
          .btn {
               display: inline-flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
               padding: 12px 24px;
               border: none;
               border-radius: var(--radius-md);
               font-weight: 600;
               text-decoration: none;
               cursor: pointer;
               transition: var(--transition);
               position: relative;
               overflow: hidden;
               font-size: 0.9rem;
          }

          button::before,
          .btn::before {
               content: '';
               position: absolute;
               top: 50%;
               left: 50%;
               width: 0;
               height: 0;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.2);
               transform: translate(-50%, -50%);
               transition: width 0.6s, height 0.6s;
          }

          button:hover::before,
          .btn:hover::before {
               width: 300px;
               height: 300px;
          }

          button:active,
          .btn:active {
               transform: scale(0.98);
          }

          /* Primārā poga */
          button:not(.delete-btn):not([type="submit"]):not(.remove-btn):not(.clear-cart-btn) {
               background: var(--primary);
               color: var(--white);
          }

          button:not(.delete-btn):not([type="submit"]):not(.remove-btn):not(.clear-cart-btn):hover {
               background: var(--primary-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .delete-btn,
          .remove-btn,
          .btn-cancel {
               background: var(--error);
               color: var(--white);
          }

          .delete-btn:hover,
          .remove-btn:hover,
          .btn-cancel:hover {
               background: var(--error-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .edit-btn {
               background: var(--success);
               color: var(--white);
          }

          .edit-btn:hover {
               background: var(--success-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .btn-secondary,
          .back-btn,
          .clear-cart-btn {
               background: var(--gray-500);
               color: var(--white);
          }

          .btn-secondary:hover,
          .back-btn:hover,
          .clear-cart-btn:hover {
               background: var(--gray-600);
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .btn-sm {
               padding: 8px 16px;
               font-size: 0.85rem;
          }

          /* === FISH PAGE COMMON STYLES === */
          .fish-page {
               padding: 20px 0;
          }

          .fish-page h1 {
               text-align: center;
               margin: 20px 0;
               color: var(--dark);
               font-weight: 700;
               font-size: 1.8rem;
          }

          .page-description {
               text-align: center;
               color: var(--gray-600);
               margin-bottom: 30px;
               max-width: 600px;
               margin-left: auto;
               margin-right: auto;
          }

          .empty-state {
               text-align: center;
               padding: 40px;
               background: var(--gray-100);
               border-radius: var(--radius-lg);
               margin: 20px 0;
          }

          .empty-state p {
               font-size: 1.1em;
               color: var(--gray-600);
          }

          .fish-grid {
               display: grid;
               grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
               gap: 24px;
               padding: 24px 0;
          }

          .fish-card {
               background: var(--white);
               border: 1px solid var(--gray-200);
               border-radius: var(--radius-xl);
               padding: 24px;
               text-align: center;
               display: flex;
               flex-direction: column;
               justify-content: space-between;
               box-shadow: var(--shadow-sm);
               transition: var(--transition);
               position: relative;
               overflow: hidden;
          }

          .fish-card::before {
               content: '';
               position: absolute;
               top: 0;
               left: -100%;
               width: 100%;
               height: 100%;
               background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
               transition: left 0.5s;
          }

          .fish-card:hover::before {
               left: 100%;
          }

          .fish-card:hover {
               transform: translateY(-8px);
               box-shadow: var(--shadow-xl);
               border-color: var(--primary-light);
          }

          .fish-card h2 {
               margin: 0 0 16px 0;
               color: var(--dark);
               font-size: 1.3rem;
               font-weight: 700;
               line-height: 1.4;
               min-height: auto;
          }

          .fish-card .price {
               font-size: 1.4rem;
               font-weight: 700;
               color: var(--success);
               margin: 12px 0;
          }

          .fish-card img {
               width: 100%;
               height: 200px;
               object-fit: contain;
               margin: 0 0 16px 0;
               border-radius: var(--radius-lg);
               background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
               padding: 12px;
               border: 1px solid var(--gray-200);
               transition: var(--transition);
          }

          .fish-card:hover img {
               transform: scale(1.05);
          }

          .fish-card .no-image {
               width: 100%;
               height: 200px;
               background: var(--gray-100);
               display: flex;
               align-items: center;
               justify-content: center;
               color: var(--gray-500);
               border: 2px dashed var(--gray-300);
               border-radius: var(--radius-lg);
               margin: 0 0 16px 0;
               font-style: italic;
          }

          .fish-card p {
               font-size: 0.9rem;
               color: var(--gray-600);
               margin-bottom: 8px;
               line-height: 1.5;
          }

          .fish-card a {
               display: inline-flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
               background: var(--primary);
               color: var(--white);
               padding: 12px 24px;
               border-radius: var(--radius-md);
               text-decoration: none;
               margin-top: 16px;
               transition: var(--transition);
               font-weight: 600;
          }

          .fish-card a:hover {
               background: var(--primary-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          /* === COMPACT GRID LAYOUT === */
          .compact-grid {
               grid-template-columns: repeat(3, 1fr);
               gap: 20px;
               padding: 20px 0;
          }

          .compact-card {
               padding: 16px;
               border: 2px solid var(--primary-light);
               transition: var(--transition);
               min-height: 320px;
               display: flex;
               flex-direction: column;
          }

          .compact-card:hover {
               transform: translateY(-5px);
               box-shadow: var(--shadow-lg);
               border-color: var(--primary);
          }

          .shop-grid {
               grid-template-columns: repeat(3, 1fr) !important;
               gap: 20px !important;
               padding: 20px 0 !important;
          }

          .shop-card {
               padding: 16px;
               border: 2px solid var(--primary-light);
               transition: var(--transition);
               min-height: 380px;
               display: flex;
               flex-direction: column;
          }

          .shop-card:hover {
               transform: translateY(-5px);
               box-shadow: var(--shadow-lg);
               border-color: var(--primary);
          }

          .shop-card .fish-image-container {
               margin-bottom: 12px;
               height: 120px;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .shop-card .fish-image {
               max-height: 120px;
               max-width: 100%;
               object-fit: contain;
               transition: var(--transition);
          }

          .shop-card:hover .fish-image {
               transform: scale(1.05);
          }

          .shop-card .no-image {
               width: 100%;
               height: 120px;
               background: var(--gray-100);
               display: flex;
               align-items: center;
               justify-content: center;
               color: var(--gray-400);
               border: 1px dashed var(--gray-300);
               border-radius: var(--radius-md);
               font-size: 1.5em;
          }

          .shop-card .fish-header {
               margin-bottom: 8px;
               text-align: center;
          }

          .shop-card .fish-header h3 {
               margin: 0;
               color: var(--dark);
               font-size: 1.1em;
               font-weight: 600;
               line-height: 1.3;
               min-height: 2.6em;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .shop-card .fish-description {
               margin-bottom: 10px;
               flex-grow: 1;
          }

          .shop-card .fish-description p {
               margin: 0;
               color: var(--gray-600);
               line-height: 1.4;
               text-align: center;
               font-size: 0.85em;
          }

          .shop-card .price-container {
               background: var(--gray-50);
               padding: 8px;
               border-radius: var(--radius-md);
               margin-bottom: 8px;
               text-align: center;
               border: 1px solid var(--gray-200);
          }

          .shop-card .price {
               margin: 0;
               color: var(--success);
               font-size: 1.2em;
               font-weight: bold;
               line-height: 1;
          }

          .shop-card .price-label {
               margin: 2px 0 0 0;
               color: var(--gray-500);
               font-size: 0.75em;
          }

          .stock-info {
               padding: 6px;
               border-radius: var(--radius-sm);
               margin-bottom: 12px;
               text-align: center;
               font-size: 0.85em;
               font-weight: 600;
          }

          .in-stock {
               background: var(--success-light, #d1fae5);
               color: var(--success-dark, #065f46);
          }

          .out-of-stock {
               background: var(--error-light, #fee2e2);
               color: var(--error-dark, #991b1b);
          }

          .stock-info p {
               margin: 0;
          }

          .add-to-cart-form {
               margin-top: auto;
          }

          .quantity-selector {
               display: flex;
               align-items: center;
               justify-content: space-between;
               background: var(--gray-50);
               padding: 8px;
               border-radius: var(--radius-sm);
               margin-bottom: 10px;
               border: 1px solid var(--gray-200);
          }

          .quantity-selector label {
               font-weight: 600;
               color: var(--gray-700);
               font-size: 0.85em;
               margin: 0;
          }

          .quantity-input {
               width: 70px;
               padding: 6px;
               border: 1px solid var(--gray-300);
               border-radius: var(--radius-sm);
               text-align: center;
               font-weight: bold;
               font-size: 0.9em;
               background: var(--white);
          }

          .quantity-input:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 2px var(--primary-light);
          }

          .btn-add-to-cart {
               width: 100%;
               background: var(--success);
               color: var(--white);
               padding: 10px;
               border: none;
               border-radius: var(--radius-md);
               cursor: pointer;
               font-weight: 600;
               font-size: 0.9em;
               transition: var(--transition);
          }

          .btn-add-to-cart:hover {
               background: var(--success-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-sm);
          }

          .out-of-stock-message {
               text-align: center;
               padding: 10px;
               background: var(--gray-100);
               border-radius: var(--radius-md);
               color: var(--gray-500);
               margin-top: auto;
               font-weight: 600;
               font-size: 0.9em;
          }

          .btn-login {
               display: block;
               background: var(--primary);
               color: var(--white);
               padding: 10px;
               border-radius: var(--radius-md);
               text-decoration: none;
               text-align: center;
               margin-top: auto;
               font-weight: 600;
               font-size: 0.9em;
               transition: var(--transition);
          }

          .btn-login:hover {
               background: var(--primary-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-sm);
          }

          .catalog-grid {
               grid-template-columns: repeat(3, 1fr) !important;
               gap: 20px !important;
               padding: 20px 0 !important;
          }

          .catalog-card {
               padding: 16px;
               border: 2px solid var(--primary-light);
               transition: var(--transition);
               min-height: 320px;
               display: flex;
               flex-direction: column;
          }

          .catalog-card:hover {
               transform: translateY(-5px);
               box-shadow: var(--shadow-lg);
               border-color: var(--primary);
          }

          .catalog-card .fish-image-container {
               margin-bottom: 12px;
               height: 140px;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .catalog-card .fish-image {
               max-height: 140px;
               max-width: 100%;
               object-fit: contain;
               transition: var(--transition);
          }

          .catalog-card:hover .fish-image {
               transform: scale(1.05);
          }

          .catalog-card .no-image {
               width: 100%;
               height: 140px;
               background: var(--gray-100);
               display: flex;
               align-items: center;
               justify-content: center;
               color: var(--gray-400);
               border: 1px dashed var(--gray-300);
               border-radius: var(--radius-md);
               font-size: 1.5em;
          }

          .catalog-card .fish-header {
               margin-bottom: 12px;
               text-align: center;
          }

          .catalog-card .fish-header h3 {
               margin: 0;
               color: var(--dark);
               font-size: 1.1em;
               font-weight: 600;
               line-height: 1.3;
               min-height: 2.6em;
               display: flex;
               align-items: center;
               justify-content: center;
          }

          .catalog-card .fish-description {
               margin-bottom: 12px;
               flex-grow: 1;
          }

          .catalog-card .fish-description p {
               margin: 0;
               color: var(--gray-600);
               line-height: 1.4;
               text-align: center;
               font-size: 0.85em;
          }

          .catalog-card .price-container {
               background: var(--gray-50);
               padding: 10px;
               border-radius: var(--radius-md);
               margin-bottom: 12px;
               text-align: center;
               border: 1px solid var(--gray-200);
          }

          .catalog-card .price {
               margin: 0;
               color: var(--success);
               font-size: 1.3em;
               font-weight: bold;
               line-height: 1;
          }

          .catalog-card .price-label {
               margin: 4px 0 0 0;
               color: var(--gray-500);
               font-size: 0.8em;
          }

          .catalog-card .contact-info {
               text-align: center;
               padding: 8px;
               background: var(--gray-100);
               border-radius: var(--radius-sm);
               margin-bottom: 12px;
          }

          .catalog-card .contact-info p {
               margin: 0;
               color: var(--gray-600);
               font-size: 0.8em;
          }

          .catalog-card .action-container {
               text-align: center;
               margin-top: auto;
          }

          .btn-view-more {
               display: inline-block;
               background: var(--primary);
               color: var(--white);
               padding: 10px 20px;
               border-radius: var(--radius-md);
               text-decoration: none;
               font-weight: 600;
               font-size: 0.9em;
               transition: var(--transition);
               width: 100%;
               text-align: center;
          }

          .btn-view-more:hover {
               background: var(--primary-dark);
               transform: translateY(-2px);
               box-shadow: var(--shadow-sm);
          }

          .contact-box {
               text-align: center;
               margin-top: 40px;
               padding: 25px;
               background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
               border-radius: var(--radius-xl);
               color: var(--white);
               box-shadow: var(--shadow-lg);
          }

          .contact-box h3 {
               margin: 0 0 15px 0;
               font-size: 1.4em;
          }

          .contact-box p {
               margin: 10px 0;
               font-size: 1.05em;
          }

          .phone-link {
               color: var(--white);
               font-size: 1.3em;
               font-weight: bold;
               text-decoration: none;
               background: rgba(255, 255, 255, 0.2);
               padding: 10px 20px;
               border-radius: var(--radius-md);
               display: inline-block;
               transition: var(--transition);
          }

          .phone-link:hover {
               background: rgba(255, 255, 255, 0.3);
               transform: translateY(-2px);
          }

          .working-hours {
               margin: 10px 0;
               font-size: 0.95em;
               opacity: 0.9;
          }

          /* === COMPACT FORM STYLES === */
          .compact-form .admin-container {
               max-width: 700px;
               padding: 15px 0;
          }

          .compact-form .admin-header {
               margin-bottom: 20px;
               gap: 12px;
          }

          .compact-form .admin-header h1 {
               font-size: 1.5rem;
          }

          .compact-form .form-container {
               background: var(--white);
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               border: 1px solid var(--gray-200);
               padding: 20px;
          }

          .compact-form .form-grid {
               display: grid;
               grid-template-columns: 1fr 1fr;
               gap: 16px;
               margin-bottom: 20px;
          }

          .compact-form .form-group {
               margin-bottom: 0;
          }

          .compact-form .form-group.full-width {
               grid-column: 1 / -1;
          }

          .compact-form .form-label {
               display: block;
               margin-bottom: 6px;
               font-weight: 600;
               color: var(--gray-700);
               font-size: 0.85rem;
          }

          .compact-form .form-input {
               width: 100%;
               padding: 10px 12px;
               border: 1px solid var(--gray-300);
               border-radius: var(--radius-md);
               font-size: 0.9rem;
               transition: var(--transition);
               background: var(--white);
          }

          .compact-form .form-input:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 3px var(--primary-light);
          }

          .compact-form .form-input.error {
               border-color: var(--error);
               box-shadow: 0 0 0 3px var(--error-light);
          }

          .compact-form .form-textarea {
               resize: vertical;
               min-height: 80px;
               font-family: inherit;
          }

          .compact-form .form-help {
               color: var(--gray-500);
               font-size: 0.8rem;
               margin-top: 4px;
               line-height: 1.4;
          }

          .compact-form .error-message {
               color: var(--error);
               font-size: 0.8rem;
               margin-top: 4px;
               font-weight: 500;
          }

          /* Stock fields */
          .compact-form .stock-row {
               display: grid;
               grid-template-columns: 1fr auto;
               gap: 10px;
               align-items: end;
          }

          .compact-form .stock-input {
               min-width: 0;
          }

          .compact-form .stock-unit {
               width: 100px;
          }

          /* Image section */
          .compact-form .image-section {
               display: flex;
               gap: 20px;
               align-items: flex-start;
          }

          .compact-form .current-image {
               text-align: center;
               flex-shrink: 0;
          }

          .compact-form .fish-image-preview {
               width: 80px;
               height: 60px;
               object-fit: cover;
               border-radius: var(--radius-sm);
               border: 1px solid var(--gray-300);
          }

          .compact-form .current-image small {
               display: block;
               margin-top: 4px;
               font-size: 0.75rem;
               color: var(--gray-500);
          }

          .compact-form .no-image {
               padding: 15px;
               background: var(--gray-100);
               border-radius: var(--radius-md);
               border: 1px dashed var(--gray-300);
               text-align: center;
               color: var(--gray-500);
               font-size: 0.85rem;
               flex-shrink: 0;
          }

          .compact-form .image-upload {
               flex: 1;
               min-width: 0;
          }

          /* Form actions */
          .compact-form .form-actions {
               padding: 20px 0 0 0;
               border-top: 1px solid var(--gray-200);
               background: transparent;
               display: flex;
               gap: 10px;
               justify-content: flex-start;
          }

          /* Show/hide stock fields */
          .compact-form .hidden {
               display: none;
          }

          .compact-form .visible {
               display: block;
               animation: fadeIn 0.2s ease-in-out;
          }

          @keyframes fadeIn {
               from {
                    opacity: 0;
               }

               to {
                    opacity: 1;
               }
          }

          /* === ADMIN FISH LIST STYLES === */
          .admin-container {
               max-width: 1400px;
               margin: 0 auto;
               padding: 20px 0;
          }

          .admin-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 24px;
               flex-wrap: wrap;
               gap: 16px;
          }

          .admin-header h1 {
               margin: 0;
               color: var(--dark);
               font-size: 1.8rem;
               font-weight: 700;
               text-align: left;
          }

          .admin-table-container {
               background: var(--white);
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               overflow: hidden;
               border: 1px solid var(--gray-200);
          }

          .admin-table {
               width: 100%;
               border-collapse: collapse;
               font-size: 0.9rem;
          }

          .admin-table th {
               background: var(--gray-50);
               color: var(--gray-700);
               padding: 16px 12px;
               text-align: left;
               font-weight: 600;
               font-size: 0.85rem;
               border-bottom: 2px solid var(--gray-200);
          }

          .admin-table td {
               padding: 12px;
               border-bottom: 1px solid var(--gray-200);
               vertical-align: middle;
          }

          .admin-table tr:last-child td {
               border-bottom: none;
          }

          .admin-table tr:hover {
               background: var(--gray-50);
          }

          /* Specific column styles */
          .fish-id {
               font-weight: 600;
               color: var(--gray-600);
               width: 60px;
          }

          .fish-name {
               font-weight: 600;
               color: var(--dark);
               min-width: 150px;
          }

          .fish-price {
               font-weight: 600;
               color: var(--success);
               width: 100px;
          }

          .fish-description {
               color: var(--gray-600);
               max-width: 200px;
               min-width: 150px;
          }

          .fish-image {
               width: 100px;
               text-align: center;
          }

          .fish-thumbnail {
               width: 80px;
               height: 60px;
               object-fit: cover;
               border-radius: var(--radius-sm);
               border: 1px solid var(--gray-300);
          }

          .no-image {
               color: var(--gray-500);
               font-style: italic;
               font-size: 0.8rem;
          }

          /* Status badges */
          .status-badge {
               display: inline-block;
               padding: 4px 8px;
               border-radius: 12px;
               font-size: 0.8rem;
               font-weight: 600;
               text-align: center;
          }

          .status-active {
               background: var(--success-light, #d1fae5);
               color: var(--success-dark, #065f46);
          }

          .status-inactive {
               background: var(--error-light, #fee2e2);
               color: var(--error-dark, #991b1b);
          }

          /* Stock info */
          .stock-info {
               text-align: center;
          }

          .stock-quantity {
               font-weight: 600;
               color: var(--dark);
               font-size: 0.85rem;
          }

          .stock-status {
               font-size: 0.75rem;
               font-weight: 500;
          }

          .stock-status.in-stock {
               color: var(--success);
          }

          .stock-status.out-of-stock {
               color: var(--error);
          }

          .not-applicable {
               color: var(--gray-400);
               font-style: italic;
          }

          /* Action buttons */
          .action-buttons {
               width: 180px;
          }

          .button-group {
               display: flex;
               flex-direction: column;
               gap: 8px;
               align-items: stretch;
          }

          .button-group .btn {
               width: 100%;
               justify-content: center;
               padding: 8px 12px;
               font-size: 0.8rem;
          }

          .btn-edit {
               background: var(--success);
               color: var(--white);
          }

          .btn-edit:hover {
               background: var(--success-dark);
          }

          .btn-delete {
               background: var(--error);
               color: var(--white);
          }

          .btn-delete:hover {
               background: var(--error-dark);
          }

          .delete-form {
               margin: 0;
               display: block;
          }

          /* === REPORTS STYLES === */
          .reports-container {
               max-width: 1400px;
               margin: 0 auto;
               padding: 20px 0;
          }

          .reports-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 24px;
               flex-wrap: wrap;
               gap: 16px;
          }

          .reports-header h1 {
               margin: 0;
               color: var(--dark);
               font-size: 1.8rem;
               text-align: left;
          }

          .header-actions {
               display: flex;
               gap: 12px;
               flex-wrap: wrap;
          }

          /* Filters */
          .filters-card {
               background: var(--white);
               padding: 24px;
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               margin-bottom: 24px;
               border: 1px solid var(--gray-200);
          }

          .filters-card h3 {
               margin: 0 0 20px 0;
               color: var(--dark);
               font-size: 1.2rem;
               font-weight: 600;
          }

          .filters-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
               gap: 16px;
               margin-bottom: 20px;
          }

          .filter-group {
               display: flex;
               flex-direction: column;
               gap: 6px;
          }

          .filter-group label {
               font-weight: 600;
               color: var(--gray-700);
               font-size: 0.85rem;
          }

          .filter-input {
               padding: 10px 12px;
               border: 2px solid var(--gray-300);
               border-radius: var(--radius-md);
               font-size: 0.9rem;
               transition: var(--transition);
               background: var(--white);
          }

          .filter-input:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 3px var(--primary-light);
          }

          .filter-actions {
               display: flex;
               gap: 12px;
               flex-wrap: wrap;
               align-items: center;
          }

          /* Reports Stats grid */
          .stats-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
               gap: 20px;
               margin-bottom: 24px;
          }

          .stats-grid .stat-card {
               background: var(--white);
               padding: 20px;
               border-radius: var(--radius-lg);
               box-shadow: var(--shadow-sm);
               text-align: center;
               border: 1px solid var(--gray-200);
               transition: var(--transition);
          }

          .stats-grid .stat-card:hover {
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .stats-grid .stat-number {
               font-size: 2rem;
               font-weight: 700;
               color: var(--primary);
               margin-bottom: 8px;
               line-height: 1;
          }

          .stats-grid .stat-label {
               color: var(--gray-600);
               font-size: 0.9rem;
               font-weight: 500;
          }

          /* Reports table */
          .reports-table {
               background: var(--white);
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               overflow: hidden;
               border: 1px solid var(--gray-200);
               margin-bottom: 24px;
          }

          .reports-table table {
               width: 100%;
               border-collapse: collapse;
          }

          .reports-table th {
               background: var(--gray-50);
               color: var(--gray-700);
               padding: 16px 12px;
               text-align: left;
               font-weight: 600;
               font-size: 0.85rem;
               border-bottom: 2px solid var(--gray-200);
          }

          .reports-table td {
               padding: 12px;
               border-bottom: 1px solid var(--gray-200);
               font-size: 0.85rem;
          }

          .reports-table tr:last-child td {
               border-bottom: none;
          }

          .reports-table tr:hover {
               background: var(--gray-50);
          }

          .text-center {
               text-align: center;
          }

          .text-right {
               text-align: right;
          }

          .batch-info {
               color: var(--gray-500);
          }

          .total-row {
               background: var(--gray-50);
               font-weight: 600;
          }

          .total-amount {
               color: var(--success);
               font-size: 1rem;
          }

          /* Product stats */
          .product-stats {
               background: var(--white);
               padding: 24px;
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               border: 1px solid var(--gray-200);
          }

          .product-stats h3 {
               margin: 0 0 20px 0;
               color: var(--dark);
               font-size: 1.2rem;
               font-weight: 600;
          }

          .product-stats-list {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
               gap: 12px;
          }

          .product-stat-item {
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 12px 16px;
               background: var(--gray-50);
               border-radius: var(--radius-md);
               border: 1px solid var(--gray-200);
          }

          .product-info {
               display: flex;
               flex-direction: column;
               gap: 4px;
          }

          .product-info strong {
               color: var(--dark);
               font-size: 0.9rem;
          }

          .product-info small {
               color: var(--gray-500);
               font-size: 0.8rem;
          }

          .product-amount {
               font-weight: bold;
               color: var(--success);
               font-size: 0.95rem;
          }

          /* === OTHER COMPONENTS === */
          .reservation-container,
          .order-detail,
          .checkout-container {
               max-width: 800px;
               margin: 0 auto;
          }

          .reservation-item,
          .order-card,
          .detail-card,
          .checkout-section {
               background: var(--white);
               padding: 24px;
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               margin-bottom: 16px;
               transition: var(--transition);
               border: 1px solid var(--gray-200);
          }

          .reservation-item:hover,
          .order-card:hover {
               transform: translateY(-4px);
               box-shadow: var(--shadow-lg);
               border-color: var(--primary-light);
          }

          .status-badge {
               display: inline-flex;
               align-items: center;
               padding: 6px 12px;
               border-radius: 20px;
               font-weight: 600;
               font-size: 0.8rem;
               text-transform: uppercase;
               letter-spacing: 0.5px;
          }

          .status-pending {
               background: #fef3c7;
               color: #92400e;
          }

          .status-confirmed {
               background: #d1fae5;
               color: #065f46;
          }

          .status-completed {
               background: #dcfce7;
               color: #166534;
          }

          .status-cancelled {
               background: #fee2e2;
               color: #991b1b;
          }

          .admin-container,
          .dashboard-container {
               max-width: 1400px;
               margin: 0 auto;
          }

          .stats,
          .dashboard-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
               gap: 20px;
               margin: 24px 0;
          }

          .stat-card,
          .dashboard-card {
               background: var(--white);
               padding: 24px;
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               text-align: center;
               transition: var(--transition);
               border: 1px solid var(--gray-200);
               text-decoration: none;
               display: block;
          }

          .dashboard-card:hover {
               transform: translateY(-6px);
               box-shadow: var(--shadow-xl);
               border-color: var(--primary);
          }

          .stat-number {
               font-size: 2.5rem;
               font-weight: 700;
               color: var(--primary);
               margin-bottom: 8px;
               line-height: 1;
          }

          .stat-label,
          .card-description {
               color: var(--gray-600);
               font-size: 0.9rem;
               font-weight: 500;
          }

          .card-title {
               color: var(--dark);
               font-size: 1.2rem;
               font-weight: 600;
               margin-bottom: 8px;
          }

          .orders-table,
          .reports-table {
               background: var(--white);
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               overflow: hidden;
               border: 1px solid var(--gray-200);
          }

          .orders-table table,
          .reports-table table {
               width: 100%;
               border-collapse: collapse;
          }

          .orders-table th,
          .reports-table th {
               background: var(--gray-50);
               color: var(--gray-700);
               padding: 16px;
               text-align: left;
               font-weight: 600;
               font-size: 0.9rem;
               border-bottom: 2px solid var(--gray-200);
          }

          .orders-table td,
          .reports-table td {
               padding: 16px;
               border-bottom: 1px solid var(--gray-200);
               font-size: 0.9rem;
          }

          .orders-table tr:last-child td,
          .reports-table tr:last-child td {
               border-bottom: none;
          }

          .orders-table tr:hover,
          .reports-table tr:hover {
               background: var(--gray-50);
          }

          footer {
               background: linear-gradient(135deg, var(--dark) 0%, var(--gray-800) 100%);
               color: var(--white);
               padding: 40px 0 20px;
               margin-top: auto;
          }

          .footer-content {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
               gap: 30px;
               margin-bottom: 30px;
          }

          .footer-section h3 {
               color: var(--white);
               margin-bottom: 16px;
               font-size: 1.1rem;
               font-weight: 600;
          }

          .footer-section p,
          .footer-section a {
               color: var(--gray-400);
               line-height: 1.6;
               margin-bottom: 8px;
               transition: var(--transition);
          }

          .footer-section a {
               text-decoration: none;
          }

          .footer-section a:hover {
               color: var(--white);
               transform: translateX(4px);
          }

          .footer-bottom {
               text-align: center;
               padding-top: 20px;
               border-top: 1px solid var(--gray-700);
          }

          .footer-bottom p {
               color: var(--gray-500);
               margin: 0;
               font-size: 0.9rem;
          }

          /* === HOME PAGE - UZLABOTS === */
          .home-hero {
               background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
               color: var(--white);
               padding: 80px 40px;
               border-radius: var(--radius-xl);
               text-align: center;
               margin: 40px 0;
               box-shadow: var(--shadow-xl);
               position: relative;
               overflow: hidden;
          }

          .home-hero::before {
               content: '';
               position: absolute;
               top: 0;
               left: 0;
               right: 0;
               bottom: 0;
               background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><path fill="white" d="M500,250c138,0,250-112,250-250S638-250,500-250S250-138,250,0S362,250,500,250z"/></svg>');
               background-size: 200px;
               animation: float 20s infinite linear;
          }

          @keyframes float {
               0% {
                    transform: translate(0, 0) rotate(0deg);
               }

               100% {
                    transform: translate(-100px, -100px) rotate(360deg);
               }
          }

          .home-hero h1 {
               font-size: 3rem;
               margin: 0 0 20px 0;
               font-weight: 800;
               position: relative;
          }

          .home-hero p {
               font-size: 1.2rem;
               margin: 10px 0;
               opacity: 0.95;
               position: relative;
          }

          .home-hero a {
               color: var(--primary);
               background: var(--white);
               padding: 16px 32px;
               border-radius: 50px;
               text-decoration: none;
               font-weight: 600;
               display: inline-block;
               margin-top: 30px;
               transition: var(--transition);
               position: relative;
               box-shadow: var(--shadow-md);
          }

          .home-hero a:hover {
               transform: translateY(-3px);
               box-shadow: var(--shadow-xl);
          }

          .order-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 24px;
               padding-bottom: 16px;
               border-bottom: 2px solid var(--gray-200);
          }

          .order-header h2 {
               margin: 0;
               color: var(--dark);
               font-size: 1.3rem;
               font-weight: 600;
          }

          .info-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
               gap: 16px;
          }

          .info-group {
               display: flex;
               flex-direction: column;
               gap: 4px;
          }

          .info-label {
               font-weight: 600;
               color: var(--gray-600);
               font-size: 0.9rem;
          }

          .info-value {
               color: var(--dark);
               font-size: 1rem;
          }

          .order-items-table {
               background: var(--white);
               border-radius: var(--radius-lg);
               overflow: hidden;
               border: 1px solid var(--gray-200);
          }

          .order-items-table table {
               width: 100%;
               border-collapse: collapse;
          }

          .order-items-table th {
               background: var(--gray-50);
               color: var(--gray-700);
               padding: 16px 12px;
               text-align: left;
               font-weight: 600;
               font-size: 0.9rem;
               border-bottom: 2px solid var(--gray-200);
          }

          .order-items-table td {
               padding: 12px;
               border-bottom: 1px solid var(--gray-200);
               font-size: 0.9rem;
          }

          .order-items-table tr:last-child td {
               border-bottom: none;
          }

          .order-items-table tr:hover {
               background: var(--gray-50);
          }

          .price-highlight {
               color: var(--success);
               font-size: 1rem;
          }

          .total-row {
               background: var(--gray-50);
               font-weight: 600;
          }

          .total-amount {
               color: var(--success);
               font-size: 1.1rem;
          }

          .notes-box {
               background: var(--white);
               padding: 20px;
               border-radius: var(--radius-lg);
               box-shadow: var(--shadow-sm);
               border: 1px solid var(--gray-200);
               margin-bottom: 20px;
          }

          .notes-box h3 {
               margin: 0 0 12px 0;
               color: var(--dark);
               font-size: 1.1rem;
               font-weight: 600;
          }

          .notes-box p {
               margin: 0;
               color: var(--gray-700);
               line-height: 1.5;
          }

          .customer-notes {
               border-left: 4px solid var(--warning);
               background: #fff9e6;
          }

          .admin-notes {
               border-left: 4px solid var(--primary);
               background: var(--primary-light);
          }

          .form-actions {
               display: flex;
               justify-content: center;
               margin-top: 30px;
               padding-top: 20px;
               border-top: 1px solid var(--gray-200);
          }

          .cancel-form {
               margin: 0;
          }

          .cart-items {
               display: flex;
               flex-direction: column;
               gap: 16px;
               margin-bottom: 30px;
          }

          .cart-item {
               display: flex;
               align-items: center;
               gap: 20px;
               padding: 20px;
               background: var(--white);
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               border: 1px solid var(--gray-200);
               transition: var(--transition);
          }

          .cart-item:hover {
               transform: translateY(-2px);
               box-shadow: var(--shadow-md);
          }

          .item-info {
               flex: 1;
          }

          .item-info h3 {
               margin: 0 0 8px 0;
               color: var(--dark);
               font-size: 1.1rem;
               font-weight: 600;
          }

          .item-info p {
               margin: 4px 0;
               color: var(--gray-600);
               font-size: 0.9rem;
          }

          .stock-info {
               color: var(--success) !important;
               font-weight: 500;
          }

          .quantity-control {
               display: flex;
               align-items: center;
               gap: 8px;
          }

          .quantity-form {
               display: flex;
               align-items: center;
               gap: 8px;
               margin: 0;
          }

          .quantity-input {
               width: 80px;
               padding: 8px 12px;
               border: 1px solid var(--gray-300);
               border-radius: var(--radius-sm);
               text-align: center;
               font-weight: 600;
               background: var(--white);
          }

          .quantity-input:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 2px var(--primary-light);
          }

          .item-price {
               font-weight: 700;
               color: var(--success);
               font-size: 1.1rem;
               min-width: 80px;
               text-align: right;
          }

          .remove-form {
               margin: 0;
          }

          .cart-summary {
               background: var(--white);
               padding: 24px;
               border-radius: var(--radius-xl);
               box-shadow: var(--shadow-sm);
               border: 1px solid var(--gray-200);
               text-align: center;
          }

          .summary-row {
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 12px 0;
               border-bottom: 1px solid var(--gray-200);
          }

          .summary-row:last-child {
               border-bottom: none;
          }

          .summary-total {
               font-size: 1.1rem;
               font-weight: 600;
          }

          .total-amount {
               color: var(--success);
               font-size: 1.2rem;
               font-weight: 700;
          }

          .checkout-btn {
               width: 100%;
               margin: 20px 0 12px 0;
               font-size: 1.1rem;
               padding: 14px 24px;
          }

          .clear-form {
               margin: 0;
          }

          .clear-form .btn {
               width: 100%;
          }

          /* === RESPONSIVE DESIGN === */
          @media (max-width: 1024px) {

               .shop-grid,
               .catalog-grid,
               .compact-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 18px !important;
               }

               .filters-grid {
                    grid-template-columns: repeat(2, 1fr);
               }

               .admin-table {
                    font-size: 0.85rem;
               }

               .admin-table th,
               .admin-table td {
                    padding: 10px 8px;
               }

               .fish-description {
                    max-width: 150px;
                    min-width: 120px;
               }

               .compact-form .form-grid {
                    grid-template-columns: 1fr;
               }
          }

          @media (max-width: 768px) {
               body {
                    font-size: 13px;
               }

               .container {
                    padding: 0 16px;
               }

               nav .container {
                    flex-direction: column;
                    padding: 12px 16px;
                    gap: 12px;
               }

               nav>.container>div {
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 4px;
               }

               nav a {
                    padding: 12px 8px;
                    font-size: 0.9rem;
               }

               h1 {
                    font-size: 1.5rem;
                    margin: 20px 0;
               }

               .fish-grid {
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                    padding: 20px 0;
               }

               .shop-grid,
               .catalog-grid,
               .compact-grid {
                    grid-template-columns: 1fr !important;
                    gap: 16px !important;
                    max-width: 400px;
                    margin: 0 auto;
               }

               .shop-card {
                    min-height: 360px;
                    padding: 14px;
               }

               .shop-card .fish-image-container {
                    height: 110px;
               }

               .shop-card .fish-image {
                    max-height: 110px;
               }

               .shop-card .fish-header h3 {
                    font-size: 1em;
               }

               .shop-card .price {
                    font-size: 1.1em;
               }

               .catalog-card {
                    min-height: 280px;
                    padding: 14px;
               }

               .catalog-card .fish-image-container {
                    height: 120px;
               }

               .catalog-card .fish-image {
                    max-height: 120px;
               }

               /* Home page responsive */
               .modern-hero {
                    padding: 60px 20px;
               }

               .hero-title {
                    font-size: 2.2rem;
               }

               .hero-subtitle {
                    font-size: 1.1rem;
               }

               .hero-features {
                    flex-direction: column;
                    gap: 15px;
               }

               .hero-actions {
                    flex-direction: column;
               }

               .btn-hero-primary,
               .btn-hero-secondary {
                    width: 100%;
                    justify-content: center;
               }

               .section-title {
                    font-size: 2rem;
               }

               .features-grid {
                    grid-template-columns: 1fr;
                    gap: 20px;
               }

               .order-steps {
                    grid-template-columns: 1fr;
                    gap: 30px;
               }

               .how-to-order,
               .contact-cta {
                    padding: 40px 20px;
               }

               .phone-number {
                    font-size: 1.2rem;
                    padding: 12px 25px;
               }

               /* Admin responsive */
               .admin-header {
                    flex-direction: column;
                    align-items: stretch;
                    text-align: center;
               }

               .admin-header .btn {
                    width: 100%;
                    text-align: center;
               }

               .admin-table-container {
                    overflow-x: auto;
               }

               .admin-table {
                    min-width: 800px;
               }

               .button-group {
                    flex-direction: row;
                    gap: 6px;
               }

               .button-group .btn {
                    font-size: 0.75rem;
                    padding: 6px 8px;
               }

               /* Success view responsive */
               .admin-container {
                    padding: 20px 16px;
               }

               .success-container {
                    padding: 30px 20px;
               }

               .success-title {
                    font-size: 1.5rem !important;
               }

               .action-buttons {
                    flex-direction: column;
                    align-items: stretch;
               }

               .action-buttons .btn {
                    width: 100%;
                    text-align: center;
               }

               .summary-header {
                    flex-direction: column;
                    gap: 12px;
                    align-items: flex-start;
               }

               /* Compact form responsive */
               .compact-form .admin-header {
                    flex-direction: column;
                    align-items: stretch;
               }

               .compact-form .admin-header .btn {
                    width: 100%;
               }

               .compact-form .image-section {
                    flex-direction: column;
                    gap: 12px;
               }

               .compact-form .current-image,
               .compact-form .no-image {
                    align-self: center;
               }

               .compact-form .form-actions {
                    flex-direction: column;
               }

               .compact-form .btn-sm {
                    width: 100%;
                    min-width: auto;
               }

               /* Reports responsive */
               .reports-header {
                    flex-direction: column;
                    align-items: stretch;
                    text-align: center;
               }

               .header-actions {
                    justify-content: center;
               }

               .filters-grid {
                    grid-template-columns: 1fr;
               }

               .filter-actions {
                    justify-content: center;
               }

               .stats-grid {
                    grid-template-columns: 1fr;
               }

               .reports-table {
                    overflow-x: auto;
               }

               .reports-table table {
                    min-width: 800px;
               }

               .product-stats-list {
                    grid-template-columns: 1fr;
               }

               .stats,
               .dashboard-grid {
                    grid-template-columns: 1fr;
                    gap: 16px;
               }

               .home-hero {
                    padding: 60px 20px;
                    margin: 20px 0;
               }

               .home-hero h1 {
                    font-size: 2rem;
               }

               .home-hero p {
                    font-size: 1rem;
               }

               .footer-content {
                    grid-template-columns: 1fr;
                    gap: 24px;
                    text-align: center;
               }

               .order-header {
                    flex-direction: column;
                    gap: 12px;
                    align-items: flex-start;
               }

               .order-footer {
                    flex-direction: column;
                    gap: 16px;
                    align-items: stretch;
               }

               .order-actions {
                    justify-content: flex-start;
               }

               .order-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
               }

               .item-price {
                    align-self: flex-end;
               }

               .order-header {
                    flex-direction: column;
                    gap: 12px;
                    align-items: flex-start;
               }

               .info-grid {
                    grid-template-columns: 1fr;
                    gap: 12px;
               }

               .order-items-table {
                    overflow-x: auto;
               }

               .order-items-table table {
                    min-width: 600px;
               }

               .form-actions {
                    justify-content: stretch;
               }

               .cancel-form .btn {
                    width: 100%;
               }

               .cart-item {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 16px;
                    text-align: center;
               }

               .quantity-control {
                    justify-content: center;
               }

               .item-price {
                    text-align: center;
               }

               .cart-summary {
                    padding: 20px;
               }
          }

          @media (max-width: 480px) {
               .cart-item {
                    padding: 16px;
               }

               .quantity-form {
                    flex-direction: column;
                    gap: 8px;
               }

               .quantity-input {
                    width: 100%;
               }

               .summary-row {
                    flex-direction: column;
                    gap: 8px;
                    text-align: center;
               }

               .home-hero {
                    padding: 40px 16px;
               }

               .home-hero h1 {
                    font-size: 1.75rem;
               }

               .modern-hero {
                    padding: 40px 16px;
               }

               .hero-title {
                    font-size: 1.75rem;
               }

               .fish-card {
                    padding: 16px;
               }

               .shop-grid,
               .catalog-grid {
                    gap: 14px !important;
               }

               .shop-card {
                    min-height: 340px;
                    padding: 12px;
               }

               .catalog-card {
                    min-height: 260px;
                    padding: 12px;
               }

               .catalog-card .fish-header h3 {
                    font-size: 1em;
               }

               .catalog-card .price {
                    font-size: 1.2em;
               }

               .quantity-selector {
                    flex-direction: column;
                    gap: 6px;
                    text-align: center;
               }

               .quantity-input {
                    width: 100%;
               }

               /* Success view mobile */
               .success-container {
                    padding: 20px 16px;
               }

               .success-icon {
                    font-size: 3rem !important;
               }

               .success-title {
                    font-size: 1.3rem !important;
               }

               .info-box {
                    padding: 16px !important;
               }

               .summary-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
               }

               .summary-item div:last-child {
                    align-self: flex-end;
               }

               /* Admin mobile */
               .admin-container {
                    padding: 16px 0;
               }

               .admin-header h1 {
                    font-size: 1.5rem;
               }

               .button-group {
                    flex-direction: column;
                    gap: 4px;
               }

               .button-group .btn {
                    font-size: 0.7rem;
                    padding: 4px 6px;
               }

               /* Compact form mobile */
               .compact-form .admin-container {
                    padding: 10px 0;
               }

               .compact-form .form-container {
                    padding: 15px;
               }

               .compact-form .stock-row {
                    grid-template-columns: 1fr;
                    gap: 8px;
               }

               .compact-form .stock-unit {
                    width: 100%;
               }

               /* Reports mobile */
               .filters-card {
                    padding: 16px;
               }

               .header-actions {
                    flex-direction: column;
                    width: 100%;
               }

               .header-actions .btn {
                    width: 100%;
                    text-align: center;
               }

               .filter-actions {
                    flex-direction: column;
               }

               .filter-actions .btn {
                    width: 100%;
                    text-align: center;
               }

               button,
               .btn {
                    padding: 10px 20px;
                    font-size: 0.85rem;
               }

               .order-actions {
                    flex-direction: column;
                    width: 100%;
               }

               .order-actions .btn {
                    width: 100%;
                    text-align: center;
               }

               .cancel-form {
                    width: 100%;
               }

               .cancel-form .btn {
                    width: 100%;
               }

               .order-items-table th,
               .order-items-table td {
                    padding: 10px 8px;
                    font-size: 0.85rem;
               }

               .notes-box {
                    padding: 16px;
               }
          }

          /* === PRINT STYLES === */
          @media print {

               nav,
               .filters-card,
               button,
               a,
               footer {
                    display: none !important;
               }

               .reports-container {
                    max-width: 100%;
               }

               .reports-table table {
                    font-size: 0.85em;
               }
          }
     </style>
</head>

<body>
     <nav>
          <div class="container">
               <div>
                    <a href="{{ route('home') }}">🏠 Mājas</a>
                    <a href="{{ route('fish.catalog') }}">🐟 Zivju katalogs</a>
                    <a href="{{ route('fish.shop') }}">🛍️ Veikals</a>
                    <a href="{{ route('batches.public') }}">⚗️ Ieplānotā Produkcijas Izgatavošana</a>
               </div>
               <div>
                    @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">⚙️ Admin Panelis</a>
                    @endif
                    <a href="{{ route('cart.index') }}">
                         🛒 Grozs
                         @if(auth()->user()->getCartCount() > 0)
                         <span class="cart-badge">
                              {{ auth()->user()->getCartCount() }}
                         </span>
                         @endif
                    </a>
                    <a href="{{ route('orders.index') }}">📦 Mani pasūtījumi</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                         @csrf
                         <button type="submit">
                              🚪 Iziet
                         </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}">🔐 Pieteikties</a>
                    <a href="{{ route('register') }}">📝 Reģistrēties</a>
                    @endauth
               </div>
          </div>
     </nav>

     <div class="container">
          @if(session('success'))
          <div class="alert alert-success">
               ✅ {{ session('success') }}
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-error">
               ❌ {{ session('error') }}
          </div>
          @endif

          @yield('content')
     </div>

     <footer>
          <div class="container">
               <div class="footer-content">
                    <div class="footer-section">
                         <h3>Zivju Veikals</h3>
                         <p>Viss garšīgākās zivis un kūpinājumi vienuviet!</p>
                    </div>
                    <div class="footer-section">
                         <h3>📞 Kontakti</h3>
                         <p>+371 12345678</p>
                         <p>✉️ info@zivjuveikals.lv</p>
                         <p>📍 Rīga, Latvija</p>
                    </div>
                    <div class="footer-section">
                         <h3>🔗 Ātrās saites</h3>
                         <p><a href="{{ route('home') }}">Mājas</a></p>
                         <p><a href="{{ route('fish.shop') }}">Veikals</a></p>
                         <p><a href="{{ route('cart.index') }}">Grozs</a></p>
                         <p><a href="{{ route('orders.index') }}">Mani pasūtījumi</a></p>
                    </div>
                    <div class="footer-section">
                         <h3>🕒 Darba laiks</h3>
                         <p>P.-P.: 8:00 - 18:00</p>
                         <p>S.: 9:00 - 16:00</p>
                         <p>Sv.: Slēgts</p>
                    </div>
               </div>
               <div class="footer-bottom">
                    <p>&copy; 2025 KarkliBC. Visas tiesības aizsargātas.</p>
               </div>
          </div>
     </footer>
</body>

</html>