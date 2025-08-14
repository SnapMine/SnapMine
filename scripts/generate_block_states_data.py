"""
This script processes block data to calculate property coefficients
and identify the default state. The result is saved in a JSON file.
"""

import json

def compute_coefficients(properties: dict) -> list[int]:
    """
    Calculates the coefficient array for a list of properties.
    Coefficients are used to calculate a unique ID for each property combination.

    Args:
        properties (dict): A dictionary of block properties.

    Returns:
        list[int]: The list of calculated coefficients.
    """
    coefficients = []
    property_values = list(properties.values())

    multiplier = 1

    for prop in reversed(property_values):
        coefficients.insert(0, multiplier)
        multiplier *= len(prop)

    return coefficients

def main():
    """
    Main function to load data, compute coefficients,
    and save the results.
    """
    try:
        with open("blocks.json", "r") as f:
            data = json.load(f)
    except FileNotFoundError:
        print("Error: 'blocks.json' not found. Make sure it's in the same directory.")
        return

    processed_blocks = {}

    for name, block in data.items():
        if "properties" in block:
            # Sorts properties to ensure a consistent order.
            sorted_properties = dict(sorted(block["properties"].items()))

            processed_blocks[name] = {
                "properties": sorted_properties,
                "coefficients": compute_coefficients(sorted_properties),
                "baseId": block["states"][0]["id"],
            }

            # Finds the default state of the block.
            for state in block["states"]:
                if "default" in state and state["default"]:
                    processed_blocks[name]["default"] = {
                        "id": state["id"],
                        "properties": state["properties"],
                    }
                    break

    with open("blocks_coefficients.json", "w") as file:
        json.dump(processed_blocks, file, indent=4)

    print("The 'blocks_coefficients.json' file was successfully created.")

if __name__ == "__main__":
    main()