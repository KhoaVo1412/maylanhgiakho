import './bootstrap';
import '../css/home-react.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import HomeApp from './home/HomeApp';
import CategoryApp from './category/CategoryApp';
import ServicesApp from './services/ServicesApp';
import PriceListApp from './pricelist/PriceListApp';
import ContactApp from './contact/ContactApp';
import NewsApp from './news/NewsApp';
import NewsDetailApp from './news/NewsDetailApp';
import ProductDetailApp from './product/ProductDetailApp';
import HeaderApp from './header/HeaderApp';
import FooterApp from './footer/FooterApp';
import CartApp from './cart/CartApp';
import PolicyApp from './policy/PolicyApp';

function mountReactApp(containerId, dataScriptId, Component) {
  const container = document.getElementById(containerId);
  if (!container) return;

  let initialData = {};
  const dataScript = document.getElementById(dataScriptId);
  if (dataScript) {
    try {
      initialData = JSON.parse(dataScript.textContent || '{}');
    } catch (e) {
      console.error(`Failed to parse initial data from #${dataScriptId}:`, e);
    }
  }

  const root = createRoot(container);
  root.render(<Component initialData={initialData} />);
}

document.addEventListener('DOMContentLoaded', () => {
  // 0. Site Header (Global across all pages)
  mountReactApp('react-header-root', 'header-initial-data', HeaderApp);

  // 0.1 Site Footer (Global across all pages)
  mountReactApp('react-footer-root', 'footer-initial-data', FooterApp);

  // 1. Home
  mountReactApp('react-home-root', 'home-initial-data', HomeApp);

  // 2. Category
  mountReactApp('react-category-root', 'category-initial-data', CategoryApp);

  // 3. Services (/dichvu)
  mountReactApp('react-services-root', 'services-initial-data', ServicesApp);

  // 4. Price List (/banggia)
  mountReactApp('react-pricelist-root', 'pricelist-initial-data', PriceListApp);

  // 5. Contact (/contact)
  mountReactApp('react-contact-root', 'contact-initial-data', ContactApp);

  // 6. News (/tintuc)
  mountReactApp('react-news-root', 'news-initial-data', NewsApp);

  // 6.1 News Detail (/tintuc-detail/{slug})
  mountReactApp('react-news-detail-root', 'news-detail-initial-data', NewsDetailApp);

  // 7. Product Detail (/san-pham/{slug})
  mountReactApp('react-product-root', 'product-initial-data', ProductDetailApp);

  // 8. Shopping Cart (/carts)
  mountReactApp('react-cart-root', 'cart-initial-data', CartApp);

  // 9. Policies (/chinh-sach-*)
  mountReactApp('react-policy-root', 'policy-initial-data', PolicyApp);
});
