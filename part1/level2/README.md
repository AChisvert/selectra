# Level 2

Sometimes, contracts have special discounts, depending on their length.

## Instructions

In this level we have added a new entity, `Contract`. We are making good progress on our product and every user can have multiple contracts. On the other side, a contract is associated with a provider.

The discount rules are as follows (`contract_length` is a positive non-zero integer):
- if `contract_length` is less or equal than 1 year -> 10% discount
- if `contract_length` is greater than 1 and less or equal than 3 -> 20% discount
- if `contract_length` is greater than 3 -> 25% discount

Write code that generates `output.json` from `data.json`
