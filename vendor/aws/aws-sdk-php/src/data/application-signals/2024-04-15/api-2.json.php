<?php
// This file was auto-generated from sdk-root/src/data/application-signals/2024-04-15/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2024-04-15', 'auth' => [ 'aws.auth#sigv4', ], 'endpointPrefix' => 'application-signals', 'protocol' => 'rest-json', 'protocols' => [ 'rest-json', ], 'serviceFullName' => 'Amazon CloudWatch Application Signals', 'serviceId' => 'Application Signals', 'signatureVersion' => 'v4', 'signingName' => 'application-signals', 'uid' => 'application-signals-2024-04-15', ], 'operations' => [ 'BatchGetServiceLevelObjectiveBudgetReport' => [ 'name' => 'BatchGetServiceLevelObjectiveBudgetReport', 'http' => [ 'method' => 'POST', 'requestUri' => '/budget-report', 'responseCode' => 200, ], 'input' => [ 'shape' => 'BatchGetServiceLevelObjectiveBudgetReportInput', ], 'output' => [ 'shape' => 'BatchGetServiceLevelObjectiveBudgetReportOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'CreateServiceLevelObjective' => [ 'name' => 'CreateServiceLevelObjective', 'http' => [ 'method' => 'POST', 'requestUri' => '/slo', 'responseCode' => 200, ], 'input' => [ 'shape' => 'CreateServiceLevelObjectiveInput', ], 'output' => [ 'shape' => 'CreateServiceLevelObjectiveOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], [ 'shape' => 'ServiceQuotaExceededException', ], [ 'shape' => 'ConflictException', ], ], ], 'DeleteServiceLevelObjective' => [ 'name' => 'DeleteServiceLevelObjective', 'http' => [ 'method' => 'DELETE', 'requestUri' => '/slo/{Id}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'DeleteServiceLevelObjectiveInput', ], 'output' => [ 'shape' => 'DeleteServiceLevelObjectiveOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], ], 'idempotent' => true, ], 'GetService' => [ 'name' => 'GetService', 'http' => [ 'method' => 'POST', 'requestUri' => '/service', 'responseCode' => 200, ], 'input' => [ 'shape' => 'GetServiceInput', ], 'output' => [ 'shape' => 'GetServiceOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'GetServiceLevelObjective' => [ 'name' => 'GetServiceLevelObjective', 'http' => [ 'method' => 'GET', 'requestUri' => '/slo/{Id}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'GetServiceLevelObjectiveInput', ], 'output' => [ 'shape' => 'GetServiceLevelObjectiveOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListServiceDependencies' => [ 'name' => 'ListServiceDependencies', 'http' => [ 'method' => 'POST', 'requestUri' => '/service-dependencies', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListServiceDependenciesInput', ], 'output' => [ 'shape' => 'ListServiceDependenciesOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListServiceDependents' => [ 'name' => 'ListServiceDependents', 'http' => [ 'method' => 'POST', 'requestUri' => '/service-dependents', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListServiceDependentsInput', ], 'output' => [ 'shape' => 'ListServiceDependentsOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListServiceLevelObjectives' => [ 'name' => 'ListServiceLevelObjectives', 'http' => [ 'method' => 'POST', 'requestUri' => '/slos', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListServiceLevelObjectivesInput', ], 'output' => [ 'shape' => 'ListServiceLevelObjectivesOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListServiceOperations' => [ 'name' => 'ListServiceOperations', 'http' => [ 'method' => 'POST', 'requestUri' => '/service-operations', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListServiceOperationsInput', ], 'output' => [ 'shape' => 'ListServiceOperationsOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListServices' => [ 'name' => 'ListServices', 'http' => [ 'method' => 'GET', 'requestUri' => '/services', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListServicesInput', ], 'output' => [ 'shape' => 'ListServicesOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'ListTagsForResource' => [ 'name' => 'ListTagsForResource', 'http' => [ 'method' => 'GET', 'requestUri' => '/tags', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListTagsForResourceRequest', ], 'output' => [ 'shape' => 'ListTagsForResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'StartDiscovery' => [ 'name' => 'StartDiscovery', 'http' => [ 'method' => 'POST', 'requestUri' => '/start-discovery', 'responseCode' => 200, ], 'input' => [ 'shape' => 'StartDiscoveryInput', ], 'output' => [ 'shape' => 'StartDiscoveryOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'TagResource' => [ 'name' => 'TagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/tag-resource', 'responseCode' => 200, ], 'input' => [ 'shape' => 'TagResourceRequest', ], 'output' => [ 'shape' => 'TagResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'ServiceQuotaExceededException', ], ], ], 'UntagResource' => [ 'name' => 'UntagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/untag-resource', 'responseCode' => 200, ], 'input' => [ 'shape' => 'UntagResourceRequest', ], 'output' => [ 'shape' => 'UntagResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], ], ], 'UpdateServiceLevelObjective' => [ 'name' => 'UpdateServiceLevelObjective', 'http' => [ 'method' => 'PATCH', 'requestUri' => '/slo/{Id}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'UpdateServiceLevelObjectiveInput', ], 'output' => [ 'shape' => 'UpdateServiceLevelObjectiveOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ThrottlingException', ], ], ], ], 'shapes' => [ 'AccessDeniedException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'ServiceErrorMessage', ], ], 'error' => [ 'httpStatusCode' => 403, 'senderFault' => true, ], 'exception' => true, ], 'AccountId' => [ 'type' => 'string', 'max' => 255, 'min' => 1, ], 'AmazonResourceName' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, ], 'Attainment' => [ 'type' => 'double', 'box' => true, ], 'AttainmentGoal' => [ 'type' => 'double', 'box' => true, ], 'AttributeMap' => [ 'type' => 'map', 'key' => [ 'shape' => 'String', ], 'value' => [ 'shape' => 'String', ], ], 'AttributeMaps' => [ 'type' => 'list', 'member' => [ 'shape' => 'AttributeMap', ], ], 'Attributes' => [ 'type' => 'map', 'key' => [ 'shape' => 'KeyAttributeName', ], 'value' => [ 'shape' => 'KeyAttributeValue', ], 'max' => 3, 'min' => 1, ], 'BatchGetServiceLevelObjectiveBudgetReportInput' => [ 'type' => 'structure', 'required' => [ 'Timestamp', 'SloIds', ], 'members' => [ 'Timestamp' => [ 'shape' => 'Timestamp', ], 'SloIds' => [ 'shape' => 'ServiceLevelObjectiveIds', ], ], ], 'BatchGetServiceLevelObjectiveBudgetReportOutput' => [ 'type' => 'structure', 'required' => [ 'Timestamp', 'Reports', 'Errors', ], 'members' => [ 'Timestamp' => [ 'shape' => 'Timestamp', ], 'Reports' => [ 'shape' => 'ServiceLevelObjectiveBudgetReports', ], 'Errors' => [ 'shape' => 'ServiceLevelObjectiveBudgetReportErrors', ], ], ], 'BudgetRequestsRemaining' => [ 'type' => 'integer', 'box' => true, ], 'BudgetSecondsRemaining' => [ 'type' => 'integer', 'box' => true, ], 'BurnRateConfiguration' => [ 'type' => 'structure', 'required' => [ 'LookBackWindowMinutes', ], 'members' => [ 'LookBackWindowMinutes' => [ 'shape' => 'BurnRateLookBackWindowMinutes', ], ], ], 'BurnRateConfigurations' => [ 'type' => 'list', 'member' => [ 'shape' => 'BurnRateConfiguration', ], 'max' => 10, 'min' => 0, ], 'BurnRateLookBackWindowMinutes' => [ 'type' => 'integer', 'box' => true, 'max' => 10080, 'min' => 1, ], 'CalendarInterval' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'DurationUnit', 'Duration', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', ], 'DurationUnit' => [ 'shape' => 'DurationUnit', ], 'Duration' => [ 'shape' => 'CalendarIntervalDuration', ], ], ], 'CalendarIntervalDuration' => [ 'type' => 'integer', 'box' => true, 'min' => 1, ], 'ConflictException' => [ 'type' => 'structure', 'required' => [ 'Message', ], 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 409, 'senderFault' => true, ], 'exception' => true, ], 'CreateServiceLevelObjectiveInput' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'ServiceLevelObjectiveName', ], 'Description' => [ 'shape' => 'ServiceLevelObjectiveDescription', ], 'SliConfig' => [ 'shape' => 'ServiceLevelIndicatorConfig', ], 'RequestBasedSliConfig' => [ 'shape' => 'RequestBasedServiceLevelIndicatorConfig', ], 'Goal' => [ 'shape' => 'Goal', ], 'Tags' => [ 'shape' => 'TagList', ], 'BurnRateConfigurations' => [ 'shape' => 'BurnRateConfigurations', ], ], ], 'CreateServiceLevelObjectiveOutput' => [ 'type' => 'structure', 'required' => [ 'Slo', ], 'members' => [ 'Slo' => [ 'shape' => 'ServiceLevelObjective', ], ], ], 'DeleteServiceLevelObjectiveInput' => [ 'type' => 'structure', 'required' => [ 'Id', ], 'members' => [ 'Id' => [ 'shape' => 'ServiceLevelObjectiveId', 'location' => 'uri', 'locationName' => 'Id', ], ], ], 'DeleteServiceLevelObjectiveOutput' => [ 'type' => 'structure', 'members' => [], ], 'Dimension' => [ 'type' => 'structure', 'required' => [ 'Name', 'Value', ], 'members' => [ 'Name' => [ 'shape' => 'DimensionName', ], 'Value' => [ 'shape' => 'DimensionValue', ], ], ], 'DimensionName' => [ 'type' => 'string', 'max' => 255, 'min' => 1, ], 'DimensionValue' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, ], 'Dimensions' => [ 'type' => 'list', 'member' => [ 'shape' => 'Dimension', ], 'max' => 30, 'min' => 0, ], 'DurationUnit' => [ 'type' => 'string', 'enum' => [ 'MINUTE', 'HOUR', 'DAY', 'MONTH', ], ], 'EvaluationType' => [ 'type' => 'string', 'enum' => [ 'PeriodBased', 'RequestBased', ], ], 'FaultDescription' => [ 'type' => 'string', ], 'GetServiceInput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'KeyAttributes', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'StartTime', ], 'EndTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'EndTime', ], 'KeyAttributes' => [ 'shape' => 'Attributes', ], ], ], 'GetServiceLevelObjectiveInput' => [ 'type' => 'structure', 'required' => [ 'Id', ], 'members' => [ 'Id' => [ 'shape' => 'ServiceLevelObjectiveId', 'location' => 'uri', 'locationName' => 'Id', ], ], ], 'GetServiceLevelObjectiveOutput' => [ 'type' => 'structure', 'required' => [ 'Slo', ], 'members' => [ 'Slo' => [ 'shape' => 'ServiceLevelObjective', ], ], ], 'GetServiceOutput' => [ 'type' => 'structure', 'required' => [ 'Service', 'StartTime', 'EndTime', ], 'members' => [ 'Service' => [ 'shape' => 'Service', ], 'StartTime' => [ 'shape' => 'Timestamp', ], 'EndTime' => [ 'shape' => 'Timestamp', ], 'LogGroupReferences' => [ 'shape' => 'LogGroupReferences', ], ], ], 'Goal' => [ 'type' => 'structure', 'members' => [ 'Interval' => [ 'shape' => 'Interval', ], 'AttainmentGoal' => [ 'shape' => 'AttainmentGoal', ], 'WarningThreshold' => [ 'shape' => 'WarningThreshold', ], ], ], 'Interval' => [ 'type' => 'structure', 'members' => [ 'RollingInterval' => [ 'shape' => 'RollingInterval', ], 'CalendarInterval' => [ 'shape' => 'CalendarInterval', ], ], 'union' => true, ], 'KeyAttributeName' => [ 'type' => 'string', 'pattern' => '[a-zA-Z]{1,50}', ], 'KeyAttributeValue' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '[ -~]*[!-~]+[ -~]*', ], 'ListServiceDependenciesInput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'KeyAttributes', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'StartTime', ], 'EndTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'EndTime', ], 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'MaxResults' => [ 'shape' => 'ListServiceDependenciesMaxResults', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListServiceDependenciesMaxResults' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 1, ], 'ListServiceDependenciesOutput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'ServiceDependencies', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', ], 'EndTime' => [ 'shape' => 'Timestamp', ], 'ServiceDependencies' => [ 'shape' => 'ServiceDependencies', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListServiceDependentsInput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'KeyAttributes', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'StartTime', ], 'EndTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'EndTime', ], 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'MaxResults' => [ 'shape' => 'ListServiceDependentsMaxResults', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListServiceDependentsMaxResults' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 1, ], 'ListServiceDependentsOutput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'ServiceDependents', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', ], 'EndTime' => [ 'shape' => 'Timestamp', ], 'ServiceDependents' => [ 'shape' => 'ServiceDependents', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListServiceLevelObjectivesInput' => [ 'type' => 'structure', 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', 'location' => 'querystring', 'locationName' => 'OperationName', ], 'MaxResults' => [ 'shape' => 'ListServiceLevelObjectivesMaxResults', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListServiceLevelObjectivesMaxResults' => [ 'type' => 'integer', 'box' => true, 'max' => 50, 'min' => 1, ], 'ListServiceLevelObjectivesOutput' => [ 'type' => 'structure', 'members' => [ 'SloSummaries' => [ 'shape' => 'ServiceLevelObjectiveSummaries', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListServiceOperationMaxResults' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 1, ], 'ListServiceOperationsInput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'KeyAttributes', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'StartTime', ], 'EndTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'EndTime', ], 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'MaxResults' => [ 'shape' => 'ListServiceOperationMaxResults', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListServiceOperationsOutput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'ServiceOperations', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', ], 'EndTime' => [ 'shape' => 'Timestamp', ], 'ServiceOperations' => [ 'shape' => 'ServiceOperations', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListServicesInput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'StartTime', ], 'EndTime' => [ 'shape' => 'Timestamp', 'location' => 'querystring', 'locationName' => 'EndTime', ], 'MaxResults' => [ 'shape' => 'ListServicesMaxResults', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListServicesMaxResults' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 1, ], 'ListServicesOutput' => [ 'type' => 'structure', 'required' => [ 'StartTime', 'EndTime', 'ServiceSummaries', ], 'members' => [ 'StartTime' => [ 'shape' => 'Timestamp', ], 'EndTime' => [ 'shape' => 'Timestamp', ], 'ServiceSummaries' => [ 'shape' => 'ServiceSummaries', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListTagsForResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', 'location' => 'querystring', 'locationName' => 'ResourceArn', ], ], ], 'ListTagsForResourceResponse' => [ 'type' => 'structure', 'members' => [ 'Tags' => [ 'shape' => 'TagList', ], ], ], 'LogGroupReferences' => [ 'type' => 'list', 'member' => [ 'shape' => 'Attributes', ], ], 'Metric' => [ 'type' => 'structure', 'members' => [ 'Namespace' => [ 'shape' => 'Namespace', ], 'MetricName' => [ 'shape' => 'MetricName', ], 'Dimensions' => [ 'shape' => 'Dimensions', ], ], ], 'MetricDataQueries' => [ 'type' => 'list', 'member' => [ 'shape' => 'MetricDataQuery', ], ], 'MetricDataQuery' => [ 'type' => 'structure', 'required' => [ 'Id', ], 'members' => [ 'Id' => [ 'shape' => 'MetricId', ], 'MetricStat' => [ 'shape' => 'MetricStat', ], 'Expression' => [ 'shape' => 'MetricExpression', ], 'Label' => [ 'shape' => 'MetricLabel', ], 'ReturnData' => [ 'shape' => 'ReturnData', ], 'Period' => [ 'shape' => 'Period', ], 'AccountId' => [ 'shape' => 'AccountId', ], ], ], 'MetricExpression' => [ 'type' => 'string', 'max' => 2048, 'min' => 1, ], 'MetricId' => [ 'type' => 'string', 'max' => 255, 'min' => 1, ], 'MetricLabel' => [ 'type' => 'string', ], 'MetricName' => [ 'type' => 'string', 'max' => 255, 'min' => 1, ], 'MetricReference' => [ 'type' => 'structure', 'required' => [ 'Namespace', 'MetricType', 'MetricName', ], 'members' => [ 'Namespace' => [ 'shape' => 'Namespace', ], 'MetricType' => [ 'shape' => 'MetricType', ], 'Dimensions' => [ 'shape' => 'Dimensions', ], 'MetricName' => [ 'shape' => 'MetricName', ], ], ], 'MetricReferences' => [ 'type' => 'list', 'member' => [ 'shape' => 'MetricReference', ], ], 'MetricStat' => [ 'type' => 'structure', 'required' => [ 'Metric', 'Period', 'Stat', ], 'members' => [ 'Metric' => [ 'shape' => 'Metric', ], 'Period' => [ 'shape' => 'Period', ], 'Stat' => [ 'shape' => 'Stat', ], 'Unit' => [ 'shape' => 'StandardUnit', ], ], ], 'MetricType' => [ 'type' => 'string', 'pattern' => '[A-Za-z0-9 -]+', ], 'MonitoredRequestCountMetricDataQueries' => [ 'type' => 'structure', 'members' => [ 'GoodCountMetric' => [ 'shape' => 'MetricDataQueries', ], 'BadCountMetric' => [ 'shape' => 'MetricDataQueries', ], ], 'union' => true, ], 'Namespace' => [ 'type' => 'string', 'max' => 255, 'min' => 1, 'pattern' => '.*[^:].*', ], 'NextToken' => [ 'type' => 'string', ], 'OperationName' => [ 'type' => 'string', 'max' => 255, 'min' => 1, ], 'Period' => [ 'type' => 'integer', 'box' => true, 'min' => 1, ], 'RequestBasedServiceLevelIndicator' => [ 'type' => 'structure', 'required' => [ 'RequestBasedSliMetric', ], 'members' => [ 'RequestBasedSliMetric' => [ 'shape' => 'RequestBasedServiceLevelIndicatorMetric', ], 'MetricThreshold' => [ 'shape' => 'ServiceLevelIndicatorMetricThreshold', ], 'ComparisonOperator' => [ 'shape' => 'ServiceLevelIndicatorComparisonOperator', ], ], ], 'RequestBasedServiceLevelIndicatorConfig' => [ 'type' => 'structure', 'required' => [ 'RequestBasedSliMetricConfig', ], 'members' => [ 'RequestBasedSliMetricConfig' => [ 'shape' => 'RequestBasedServiceLevelIndicatorMetricConfig', ], 'MetricThreshold' => [ 'shape' => 'ServiceLevelIndicatorMetricThreshold', ], 'ComparisonOperator' => [ 'shape' => 'ServiceLevelIndicatorComparisonOperator', ], ], ], 'RequestBasedServiceLevelIndicatorMetric' => [ 'type' => 'structure', 'required' => [ 'TotalRequestCountMetric', 'MonitoredRequestCountMetric', ], 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', ], 'MetricType' => [ 'shape' => 'ServiceLevelIndicatorMetricType', ], 'TotalRequestCountMetric' => [ 'shape' => 'MetricDataQueries', ], 'MonitoredRequestCountMetric' => [ 'shape' => 'MonitoredRequestCountMetricDataQueries', ], ], ], 'RequestBasedServiceLevelIndicatorMetricConfig' => [ 'type' => 'structure', 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', ], 'MetricType' => [ 'shape' => 'ServiceLevelIndicatorMetricType', ], 'TotalRequestCountMetric' => [ 'shape' => 'MetricDataQueries', ], 'MonitoredRequestCountMetric' => [ 'shape' => 'MonitoredRequestCountMetricDataQueries', ], ], ], 'ResourceId' => [ 'type' => 'string', ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'required' => [ 'ResourceType', 'ResourceId', 'Message', ], 'members' => [ 'ResourceType' => [ 'shape' => 'ResourceType', ], 'ResourceId' => [ 'shape' => 'ResourceId', ], 'Message' => [ 'shape' => 'FaultDescription', ], ], 'error' => [ 'httpStatusCode' => 404, 'senderFault' => true, ], 'exception' => true, ], 'ResourceType' => [ 'type' => 'string', ], 'ReturnData' => [ 'type' => 'boolean', 'box' => true, ], 'RollingInterval' => [ 'type' => 'structure', 'required' => [ 'DurationUnit', 'Duration', ], 'members' => [ 'DurationUnit' => [ 'shape' => 'DurationUnit', ], 'Duration' => [ 'shape' => 'RollingIntervalDuration', ], ], ], 'RollingIntervalDuration' => [ 'type' => 'integer', 'box' => true, 'min' => 1, ], 'SLIPeriodSeconds' => [ 'type' => 'integer', 'box' => true, 'max' => 900, 'min' => 60, ], 'Service' => [ 'type' => 'structure', 'required' => [ 'KeyAttributes', 'MetricReferences', ], 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'AttributeMaps' => [ 'shape' => 'AttributeMaps', ], 'MetricReferences' => [ 'shape' => 'MetricReferences', ], 'LogGroupReferences' => [ 'shape' => 'LogGroupReferences', ], ], ], 'ServiceDependencies' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceDependency', ], 'max' => 100, 'min' => 0, ], 'ServiceDependency' => [ 'type' => 'structure', 'required' => [ 'OperationName', 'DependencyKeyAttributes', 'DependencyOperationName', 'MetricReferences', ], 'members' => [ 'OperationName' => [ 'shape' => 'OperationName', ], 'DependencyKeyAttributes' => [ 'shape' => 'Attributes', ], 'DependencyOperationName' => [ 'shape' => 'OperationName', ], 'MetricReferences' => [ 'shape' => 'MetricReferences', ], ], ], 'ServiceDependent' => [ 'type' => 'structure', 'required' => [ 'DependentKeyAttributes', 'MetricReferences', ], 'members' => [ 'OperationName' => [ 'shape' => 'OperationName', ], 'DependentKeyAttributes' => [ 'shape' => 'Attributes', ], 'DependentOperationName' => [ 'shape' => 'OperationName', ], 'MetricReferences' => [ 'shape' => 'MetricReferences', ], ], ], 'ServiceDependents' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceDependent', ], 'max' => 100, 'min' => 0, ], 'ServiceErrorMessage' => [ 'type' => 'string', ], 'ServiceLevelIndicator' => [ 'type' => 'structure', 'required' => [ 'SliMetric', 'MetricThreshold', 'ComparisonOperator', ], 'members' => [ 'SliMetric' => [ 'shape' => 'ServiceLevelIndicatorMetric', ], 'MetricThreshold' => [ 'shape' => 'ServiceLevelIndicatorMetricThreshold', ], 'ComparisonOperator' => [ 'shape' => 'ServiceLevelIndicatorComparisonOperator', ], ], ], 'ServiceLevelIndicatorComparisonOperator' => [ 'type' => 'string', 'enum' => [ 'GreaterThanOrEqualTo', 'GreaterThan', 'LessThan', 'LessThanOrEqualTo', ], ], 'ServiceLevelIndicatorConfig' => [ 'type' => 'structure', 'required' => [ 'SliMetricConfig', 'MetricThreshold', 'ComparisonOperator', ], 'members' => [ 'SliMetricConfig' => [ 'shape' => 'ServiceLevelIndicatorMetricConfig', ], 'MetricThreshold' => [ 'shape' => 'ServiceLevelIndicatorMetricThreshold', ], 'ComparisonOperator' => [ 'shape' => 'ServiceLevelIndicatorComparisonOperator', ], ], ], 'ServiceLevelIndicatorMetric' => [ 'type' => 'structure', 'required' => [ 'MetricDataQueries', ], 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', ], 'MetricType' => [ 'shape' => 'ServiceLevelIndicatorMetricType', ], 'MetricDataQueries' => [ 'shape' => 'MetricDataQueries', ], ], ], 'ServiceLevelIndicatorMetricConfig' => [ 'type' => 'structure', 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', ], 'MetricType' => [ 'shape' => 'ServiceLevelIndicatorMetricType', ], 'Statistic' => [ 'shape' => 'ServiceLevelIndicatorStatistic', ], 'PeriodSeconds' => [ 'shape' => 'SLIPeriodSeconds', ], 'MetricDataQueries' => [ 'shape' => 'MetricDataQueries', ], ], ], 'ServiceLevelIndicatorMetricThreshold' => [ 'type' => 'double', 'box' => true, ], 'ServiceLevelIndicatorMetricType' => [ 'type' => 'string', 'enum' => [ 'LATENCY', 'AVAILABILITY', ], ], 'ServiceLevelIndicatorStatistic' => [ 'type' => 'string', 'max' => 20, 'min' => 1, 'pattern' => '[a-zA-Z0-9.]+', ], 'ServiceLevelObjective' => [ 'type' => 'structure', 'required' => [ 'Arn', 'Name', 'CreatedTime', 'LastUpdatedTime', 'Goal', ], 'members' => [ 'Arn' => [ 'shape' => 'ServiceLevelObjectiveArn', ], 'Name' => [ 'shape' => 'ServiceLevelObjectiveName', ], 'Description' => [ 'shape' => 'ServiceLevelObjectiveDescription', ], 'CreatedTime' => [ 'shape' => 'Timestamp', ], 'LastUpdatedTime' => [ 'shape' => 'Timestamp', ], 'Sli' => [ 'shape' => 'ServiceLevelIndicator', ], 'RequestBasedSli' => [ 'shape' => 'RequestBasedServiceLevelIndicator', ], 'EvaluationType' => [ 'shape' => 'EvaluationType', ], 'Goal' => [ 'shape' => 'Goal', ], 'BurnRateConfigurations' => [ 'shape' => 'BurnRateConfigurations', ], ], ], 'ServiceLevelObjectiveArn' => [ 'type' => 'string', 'max' => 2048, 'min' => 1, 'pattern' => 'arn:aws:application-signals:[^:]*:[^:]*:slo/[0-9A-Za-z][-._0-9A-Za-z ]{0,126}[0-9A-Za-z]', ], 'ServiceLevelObjectiveBudgetReport' => [ 'type' => 'structure', 'required' => [ 'Arn', 'Name', 'BudgetStatus', ], 'members' => [ 'Arn' => [ 'shape' => 'ServiceLevelObjectiveArn', ], 'Name' => [ 'shape' => 'ServiceLevelObjectiveName', ], 'EvaluationType' => [ 'shape' => 'EvaluationType', ], 'BudgetStatus' => [ 'shape' => 'ServiceLevelObjectiveBudgetStatus', ], 'Attainment' => [ 'shape' => 'Attainment', ], 'TotalBudgetSeconds' => [ 'shape' => 'TotalBudgetSeconds', ], 'BudgetSecondsRemaining' => [ 'shape' => 'BudgetSecondsRemaining', ], 'TotalBudgetRequests' => [ 'shape' => 'TotalBudgetRequests', ], 'BudgetRequestsRemaining' => [ 'shape' => 'BudgetRequestsRemaining', ], 'Sli' => [ 'shape' => 'ServiceLevelIndicator', ], 'RequestBasedSli' => [ 'shape' => 'RequestBasedServiceLevelIndicator', ], 'Goal' => [ 'shape' => 'Goal', ], ], ], 'ServiceLevelObjectiveBudgetReportError' => [ 'type' => 'structure', 'required' => [ 'Name', 'Arn', 'ErrorCode', 'ErrorMessage', ], 'members' => [ 'Name' => [ 'shape' => 'ServiceLevelObjectiveName', ], 'Arn' => [ 'shape' => 'ServiceLevelObjectiveArn', ], 'ErrorCode' => [ 'shape' => 'ServiceLevelObjectiveBudgetReportErrorCode', ], 'ErrorMessage' => [ 'shape' => 'ServiceLevelObjectiveBudgetReportErrorMessage', ], ], ], 'ServiceLevelObjectiveBudgetReportErrorCode' => [ 'type' => 'string', ], 'ServiceLevelObjectiveBudgetReportErrorMessage' => [ 'type' => 'string', ], 'ServiceLevelObjectiveBudgetReportErrors' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceLevelObjectiveBudgetReportError', ], 'max' => 50, 'min' => 0, ], 'ServiceLevelObjectiveBudgetReports' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceLevelObjectiveBudgetReport', ], 'max' => 50, 'min' => 0, ], 'ServiceLevelObjectiveBudgetStatus' => [ 'type' => 'string', 'enum' => [ 'OK', 'WARNING', 'BREACHED', 'INSUFFICIENT_DATA', ], ], 'ServiceLevelObjectiveDescription' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, ], 'ServiceLevelObjectiveId' => [ 'type' => 'string', 'pattern' => '[0-9A-Za-z][-._0-9A-Za-z ]{0,126}[0-9A-Za-z]$|^arn:aws:application-signals:[^:]*:[^:]*:slo/[0-9A-Za-z][-._0-9A-Za-z ]{0,126}[0-9A-Za-z]', ], 'ServiceLevelObjectiveIds' => [ 'type' => 'list', 'member' => [ 'shape' => 'String', ], 'max' => 50, 'min' => 1, ], 'ServiceLevelObjectiveName' => [ 'type' => 'string', 'pattern' => '[0-9A-Za-z][-._0-9A-Za-z ]{0,126}[0-9A-Za-z]', ], 'ServiceLevelObjectiveSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceLevelObjectiveSummary', ], ], 'ServiceLevelObjectiveSummary' => [ 'type' => 'structure', 'required' => [ 'Arn', 'Name', ], 'members' => [ 'Arn' => [ 'shape' => 'ServiceLevelObjectiveArn', ], 'Name' => [ 'shape' => 'ServiceLevelObjectiveName', ], 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'OperationName' => [ 'shape' => 'OperationName', ], 'CreatedTime' => [ 'shape' => 'Timestamp', ], ], ], 'ServiceOperation' => [ 'type' => 'structure', 'required' => [ 'Name', 'MetricReferences', ], 'members' => [ 'Name' => [ 'shape' => 'OperationName', ], 'MetricReferences' => [ 'shape' => 'MetricReferences', ], ], ], 'ServiceOperations' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceOperation', ], 'max' => 100, 'min' => 0, ], 'ServiceQuotaExceededException' => [ 'type' => 'structure', 'required' => [ 'Message', ], 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 402, 'senderFault' => true, ], 'exception' => true, ], 'ServiceSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'ServiceSummary', ], ], 'ServiceSummary' => [ 'type' => 'structure', 'required' => [ 'KeyAttributes', 'MetricReferences', ], 'members' => [ 'KeyAttributes' => [ 'shape' => 'Attributes', ], 'AttributeMaps' => [ 'shape' => 'AttributeMaps', ], 'MetricReferences' => [ 'shape' => 'MetricReferences', ], ], ], 'StandardUnit' => [ 'type' => 'string', 'enum' => [ 'Microseconds', 'Milliseconds', 'Seconds', 'Bytes', 'Kilobytes', 'Megabytes', 'Gigabytes', 'Terabytes', 'Bits', 'Kilobits', 'Megabits', 'Gigabits', 'Terabits', 'Percent', 'Count', 'Bytes/Second', 'Kilobytes/Second', 'Megabytes/Second', 'Gigabytes/Second', 'Terabytes/Second', 'Bits/Second', 'Kilobits/Second', 'Megabits/Second', 'Gigabits/Second', 'Terabits/Second', 'Count/Second', 'None', ], ], 'StartDiscoveryInput' => [ 'type' => 'structure', 'members' => [], ], 'StartDiscoveryOutput' => [ 'type' => 'structure', 'members' => [], ], 'Stat' => [ 'type' => 'string', ], 'String' => [ 'type' => 'string', ], 'Tag' => [ 'type' => 'structure', 'required' => [ 'Key', 'Value', ], 'members' => [ 'Key' => [ 'shape' => 'TagKey', ], 'Value' => [ 'shape' => 'TagValue', ], ], ], 'TagKey' => [ 'type' => 'string', 'max' => 128, 'min' => 1, ], 'TagKeyList' => [ 'type' => 'list', 'member' => [ 'shape' => 'TagKey', ], 'max' => 200, 'min' => 0, ], 'TagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Tag', ], 'max' => 200, 'min' => 0, ], 'TagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'Tags', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', ], 'Tags' => [ 'shape' => 'TagList', ], ], ], 'TagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'TagValue' => [ 'type' => 'string', 'max' => 256, 'min' => 0, ], 'ThrottlingException' => [ 'type' => 'structure', 'required' => [ 'Message', ], 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 429, 'senderFault' => true, ], 'exception' => true, ], 'Timestamp' => [ 'type' => 'timestamp', ], 'TotalBudgetRequests' => [ 'type' => 'integer', 'box' => true, ], 'TotalBudgetSeconds' => [ 'type' => 'integer', 'box' => true, ], 'UntagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'TagKeys', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', ], 'TagKeys' => [ 'shape' => 'TagKeyList', ], ], ], 'UntagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'UpdateServiceLevelObjectiveInput' => [ 'type' => 'structure', 'required' => [ 'Id', ], 'members' => [ 'Id' => [ 'shape' => 'ServiceLevelObjectiveId', 'location' => 'uri', 'locationName' => 'Id', ], 'Description' => [ 'shape' => 'ServiceLevelObjectiveDescription', ], 'SliConfig' => [ 'shape' => 'ServiceLevelIndicatorConfig', ], 'RequestBasedSliConfig' => [ 'shape' => 'RequestBasedServiceLevelIndicatorConfig', ], 'Goal' => [ 'shape' => 'Goal', ], 'BurnRateConfigurations' => [ 'shape' => 'BurnRateConfigurations', ], ], ], 'UpdateServiceLevelObjectiveOutput' => [ 'type' => 'structure', 'required' => [ 'Slo', ], 'members' => [ 'Slo' => [ 'shape' => 'ServiceLevelObjective', ], ], ], 'ValidationException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'ValidationExceptionMessage', ], ], 'error' => [ 'httpStatusCode' => 400, 'senderFault' => true, ], 'exception' => true, ], 'ValidationExceptionMessage' => [ 'type' => 'string', ], 'WarningThreshold' => [ 'type' => 'double', 'box' => true, ], ],];
