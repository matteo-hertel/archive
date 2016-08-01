git filter-branch --commit-filter 'if [ "$GIT_AUTHOR_EMAIL" = "matteo@feastcreative.com" ];
  then export GIT_AUTHOR_NAME="Matteo Hertel"; export GIT_AUTHOR_EMAIL=info@matteohertel.com;
    fi; git commit-tree "$@"'
