# 🧰 Target Team Member Tools

A growing web-based toolbox designed to support Target team members with real-time productivity calculations, staffing recommendations, and operational utilities. This project currently includes the Priority Pull Calculator, with additional tools coming soon.

## ⭐ Current Feature: Priority Pull Calculator

The Priority Pull Calculator helps team members and leaders estimate the number of pulls required to hit a desired goal percentage, while accounting for live store hours, guest shopping impacts, and projected workload.

### 🔧 How It Works

The calculator is powered by logic that mirrors the included Python model, rewritten in JavaScript for live browser use. It performs the following:

1. ⏱️ Time-Based Operational Logic

    * Calculates hours since store open (Assumes 7am)

    * Calculates hours remaining until store close (Assumes 10pm)

    * Adjusts for edge-cases where calculations could fail shortly after open or before close

    * Future enhancement: Safety windows for after-hours use

2. 📈 Performance Modeling

    * Computes OPCR (Operational Priority Creation Rate)

    * Computes PCR (Priority Creation Rate) and flow modifier

    * Estimates how objectives shift based on live guest shopping and priority creation

3. 📦 Pull Requirements 

    * For any given:
        * Current Priority Count 
        * Priority Filled 
        * Goal Percentage 
    * The tool returns:
      * Required Pulls — base number needed to reach the goal 
      * Adjusted Pulls — compensation for expected new guest-generated priorities
      * Staffing Reccomendations

### 👥 Staffing Recommendation

Based on:

* Projected total priorities (current + future)

* Pull rate (default: 53.7887 items/hr)

* Hours remaining in shift

The tool recommends how many team members should be pulling to stay on track.

## 🚧 Upcoming Features

The toolbox is expanding! Below are confirmed upcoming modules:

1. 📇 Barcode Generator Suite 
   * A multi-purpose barcode creation tool designed to help TMs quickly generate scannable labels for operational use. 
     * Planned barcode types:
       * Backroom locations 
       * OPU carts 
       * Drive-Up carts 
     * Optional descriptions under barcodes


📌 Project Goal

To provide Target team members with accurate, fast, easy-to-use digital tools that reduce friction, increase accuracy, and support store operational excellence.

# [📝 License](https://github.com/Randyiscoding/TGTPulls/blob/c7ed5004d416d69f3f56d1370ff8a96632e7be16/LICENSE "Licensing")
