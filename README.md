# ResiliMart — AI-Powered Supply Chain Risk Intelligence Platform

> An ERP-style web platform that maps suppliers and shipping routes, continuously monitors global risk signals, and sends early warning alerts with practical alternatives — combined with AI-based demand forecasting.

**Author:** Kalindu Gayanjith (B.G.K Gayanjith)
Software Engineer | BSc (Hons) in Management Information Systems | MSc in Artificial Intelligence (reading)

---

## Overview

**ResiliMart** is an MSc Artificial Intelligence final-year project designed as a web-based, ERP-style system that goes beyond routine business operations. While it includes a full e-commerce and operations layer (CRM, sales, product, inventory, warehouse, and material management), its core research focus is an **AI-driven supply chain risk intelligence module**.

Most existing tools spreadsheets, traditional ERPs, and even commercial risk platforms are good at tracking what's happening *inside* a business, but blind to *external* disruptions such as storms, strikes, port delays, or sudden regulatory changes. ResiliMart closes this gap by linking real-world risk signals directly to a company's specific suppliers and shipping routes, then issuing early warnings with actionable alternatives.

## Problem Statement

Many manufacturing and import-dependent companies rely on international suppliers and shipping routes, but their current tools only reflect internal operations. When a storm, strike, port delay, or supplier shutdown occurs, managers often find out only after production has already slowed or stopped leading to missed deliveries, emergency costs, and loss of customer trust.

## Proposed Solution

ResiliMart is a web-based AI-powered platform that:

- Maps a company's suppliers, routes, and operational data like a lightweight ERP
- Continuously monitors external risk signals (weather, port congestion, strikes, major news, regulations)
- Matches global events to a company's exact suppliers and routes using AI-based risk matching
- Sends early, clear alerts with estimated impact and practical alternatives (backup suppliers, rerouting, earlier ordering)
- Forecasts demand to support smarter reorder planning

## System Architecture

ResiliMart runs as two connected web applications sharing a single backend and database:

```
                         ┌─────────────────────────┐
                         │        MySQL DB          │
                         └────────────┬─────────────┘
                                      │
                         ┌────────────┴─────────────┐
                         │      Laravel Backend      │
                         │   (API / Business Logic / │
                         │    AI Risk Matching Layer)│
                         └──────┬──────────────┬─────┘
                                │              │
                 ┌──────────────┘              └──────────────┐
                 │                                             │
   ┌─────────────▼─────────────┐               ┌───────────────▼──────────────┐
   │   Main Domain (Storefront) │               │  Subdomain (Admin Dashboard)  │
   │   e.g. resilimart.com      │               │  e.g. resilimart.com/backend │
   │   Vue.js — customer-facing │               │  Vue.js — internal management │
   │   e-commerce / ordering UI │               │  CRM, inventory, risk console │
   └─────────────────────────────┘               └────────────────────────────┘
```

- **Main domain** — public-facing e-commerce style site (browsing, ordering, customer interactions)
- **Subdomain (e.g. `domain/backend`)** — internal admin dashboard for CRM, sales, inventory, warehouse, material management, user administration, and the AI risk intelligence console
- **Shared Laravel API backend** — serves both applications and houses the AI risk-matching logic
- **MySQL** — single structured relational database for all operational and risk data

## Core Features

1. Supplier and route registration with a visual mapping dashboard
2. Real-time risk monitoring using weather, news, port, and shipping data sources
3. AI-powered risk matching that connects global events to specific suppliers and routes
4. Early warning alerts with impact estimates and suggested alternatives
5. Demand forecasting module with reorder quantity recommendations
6. Reports and export tools for management review

## System Modules

| Module | Description |
|---|---|
| **CRM Management** | Maintains organized customer records, contact details, and engagement history |
| **Sales Management** | Order creation, sales tracking, and structured sales workflow |
| **Product Management** | Product details — names, descriptions, prices, variations, images, status |
| **Product Category Management** | Creation and organization of product categories |
| **Inventory Management** | Tracks product availability and stock movement |
| **Warehouse Management** | Manages storage locations and warehouse-level handling |
| **Material Management** | Tracks materials required for supply chain and operational processes |
| **User Management** | Manages users, roles, and access control |
| **Customer Management** | Stores customer details for order processing and CRM |
| **Order Management** | Tracks order status, payment status, shipping, and totals |
| **Order Item Management** | Links products to orders with quantity, variation, and pricing |
| **AI Risk Management Module** | Core research module — detects, evaluates, and reports supply chain risk and disruption scenarios |

## AI Component

As the central research contribution of this MSc project, the AI layer focuses on:

- Detecting possible risk conditions from external data signals
- Evaluating the severity and likely impact of identified risks
- Supporting stress-testing scenarios for supply chain disruption
- Improving visibility into ongoing or emerging disruptions
- Assisting decision-makers with intelligent, data-driven recommendations

This distinguishes ResiliMart from a conventional ERP system by combining enterprise operations with AI-oriented supply chain resilience analysis.

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | Vue.js |
| State Management | Vuex |
| Backend | Laravel (PHP) |
| Database | MySQL |
| UI Styling | Bootstrap + custom CSS |
| Version Control | Git / GitHub |
| AI / Risk Logic | Rule-based + AI/NLP risk matching (Laravel service layer) |

## Future Enhancements

- Advanced predictive models for risk forecasting
- Supplier management integration
- Real-time dashboards for monitoring operations and risk
- Automated alert mechanisms for high-severity events
- Expanded demand forecasting capabilities
- Visual analytics for stress-testing results
- Mitigation strategy recommendation engine
- Mobile push notifications for critical alerts

## License

This project is developed as part of an MSc in Artificial Intelligence academic program. All rights reserved by the author unless otherwise specified.

---

*ResiliMart — connecting global risk signals to the suppliers and routes that matter most.*