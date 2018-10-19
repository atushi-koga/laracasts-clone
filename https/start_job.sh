docker-compose up -d
bash job_script.sh ; RETURN=$?
docker-compose down
exit $RETURN
