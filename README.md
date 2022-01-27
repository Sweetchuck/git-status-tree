# Git status tree

[![CircleCI](https://circleci.com/gh/Sweetchuck/git-status-tree/tree/1.x.svg?style=svg)](https://circleci.com/gh/Sweetchuck/git-status-tree/?branch=1.x)
[![codecov](https://codecov.io/gh/Sweetchuck/git-status-tree/branch/1.x/graph/badge.svg?token=HSF16OGPyr)](https://app.codecov.io/gh/Sweetchuck/git-status-tree/branch/1.x)

`git status`
```
On branch 1.x
Your branch is up to date with 'upstream/1.x'.

Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
        new file:   .git-hooks

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   src/Color.php
        modified:   src/Commands/StatusTreeCommand.php
        modified:   src/EntryComparer.php
```


---


`git status-tree`
```
│
├──    src/
│   ├──    Commands/
│   │   └──  M StatusTreeCommand.php
│   ├──  M Color.php
│   └──  M EntryComparer.php
├── A  .git-hooks
└──  M README.md
```


## Requirements

* PHP >= 7.4


## Install

1. Download the `git-status-tree.phar` file from the latest [release](https://github.com/Sweetchuck/git-status-tree/releases).
2. `mv ~/Downloads/git-status-tree.phar ~/bin/git-status-tree`
3. `chmod +x ~/bin/git-status-tree`
4. `git status-tree`
5. Have fun
