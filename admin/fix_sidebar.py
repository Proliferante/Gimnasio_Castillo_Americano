import glob
import os

for fpath in glob.glob("*.php"):
    with open(fpath, "r", encoding="utf-8") as f:
        content = f.read()
    
    # Fix sidebar height 
    new_content = content.replace(
        "        #sidebar {\n            width: var(--sidebar-w);\n            min-height: 100vh;",
        "        #sidebar {\n            width: var(--sidebar-w);\n            height: 100vh;"
    )

    if new_content != content:
        with open(fpath, "w", encoding="utf-8") as f:
            f.write(new_content)
        print(f"Fixed sidebar in {fpath}")

