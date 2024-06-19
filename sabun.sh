#!/bin/bash

# カレントブランチを取得
current_branch=$(git branch --show-current)
main_branch="main"

# Mainブランチに移動してfetch
if [ "$current_branch" != main_branch ]; then
  git switch main
fi

git fetch origin

# main以外のブランチの場合mainに移動
if [ "$current_branch" != main_branch ]; then
  git switch "$current_branch"
fi

# 差分を確認
diff_output=$(git diff "$current_branch" origin/main)

if [ -n "$diff_output" ]; then
  echo "差分があるぞ. $current_branch and origin/main."
  exit 1
else
  echo "差分はない、Pushを許そうじゃないか. $current_branch and origin/main"
fi
